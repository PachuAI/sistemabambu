<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'cliente_id',
        'nivel_descuento_id',
        'monto_bruto',
        'monto_final',
        'estado',
        'fecha_reparto'
    ];

    protected $casts = [
        'monto_bruto' => 'decimal:2',
        'monto_final' => 'decimal:2',
        'fecha_reparto' => 'date',
    ];

    /** @return BelongsTo<Cliente> */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    /** @return BelongsTo<NivelDescuento> */
    public function nivelDescuento(): BelongsTo
    {
        return $this->belongsTo(NivelDescuento::class);
    }

    /** @return HasMany<PedidoItem> */
    public function items(): HasMany
    {
        return $this->hasMany(PedidoItem::class);
    }

    /** @return HasMany<MovimientoStock> */
    public function movimientosStock(): HasMany
    {
        return $this->hasMany(MovimientoStock::class);
    }

    /** @return HasMany<Reparto> */
    public function repartos(): HasMany
    {
        return $this->hasMany(Reparto::class);
    }

    /**
     * Calcula el total de bultos del pedido
     * Basado en peso total: cada 5kg = 1 bulto
     */
    public function getBultosTotalesAttribute(): float
    {
        $pesoTotal = $this->items->sum(function($item) {
            // Verificar que el producto existe y tiene peso_kg
            if ($item->producto && $item->producto->peso_kg) {
                return $item->cantidad * $item->producto->peso_kg;
            }
            // Si el producto fue eliminado, usar peso por defecto de 5kg
            return $item->cantidad * 5.0;
        });
        
        return round($pesoTotal / 5, 2);
    }

    /**
     * Genera un texto formateado del pedido para copiar/pegar
     * Mantiene compatibilidad con flujo Excel actual
     */
    public function getTextoFormateadoAttribute(): string
    {
        $texto = $this->cliente->nombre . "\n";
        $texto .= $this->cliente->telefono . "\n";
        $texto .= "$" . number_format($this->monto_final, 0) . "\n";
        
        // Agrupar productos por tipo para resumen
        $resumen = [];
        foreach ($this->items as $item) {
            if ($item->producto) {
                if ($item->producto->es_combo) {
                    $resumen[] = $item->cantidad . " combo " . $item->producto->nombre;
                } else {
                    $nombre = strtolower($item->producto->nombre);
                    if (str_contains($nombre, 'lavandina')) {
                        $resumen[] = $item->cantidad . " lavandina";
                    } else {
                        $resumen[] = $item->cantidad . " " . $item->producto->nombre;
                    }
                }
            } else {
                // Si el producto fue eliminado, usar información genérica
                $resumen[] = $item->cantidad . " producto (eliminado)";
            }
        }
        
        return $texto . implode("\n", $resumen);
    }
}
