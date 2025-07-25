<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reparto extends Model
{
    protected $fillable = [
        'fecha_reparto',
        'vehiculo_id',
        'pedido_id',
        'bultos_asignados',
        'orden_entrega',
        'estado',
        'observaciones'
    ];

    protected $casts = [
        'fecha_reparto' => 'date',
    ];

    /** @return BelongsTo<Vehiculo> */
    public function vehiculo(): BelongsTo
    {
        return $this->belongsTo(Vehiculo::class);
    }

    /** @return BelongsTo<Pedido> */
    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }

    /**
     * Scope para filtrar por fecha
     */
    public function scopePorFecha($query, $fecha)
    {
        return $query->where('fecha_reparto', $fecha);
    }

    /**
     * Scope para filtrar por vehículo
     */
    public function scopePorVehiculo($query, $vehiculoId)
    {
        return $query->where('vehiculo_id', $vehiculoId);
    }

    /**
     * Scope para ordenar por orden de entrega
     */
    public function scopeOrdenadoPorEntrega($query)
    {
        return $query->orderBy('orden_entrega');
    }
}