<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    protected $fillable = [
        'usuario',
        'accion',
        'data',
        'modulo',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Método estático para crear un log fácilmente
     */
    public static function log(string $usuario, string $accion, string $modulo = null, array $data = null): void
    {
        self::create([
            'usuario' => $usuario,
            'accion' => $accion,
            'modulo' => $modulo,
            'data' => $data,
        ]);
    }

    /**
     * Logs específicos para cambios de stock
     */
    public static function logStockChange(string $usuario, string $productoNombre, int $cantidadAnterior, int $cantidadNueva, string $motivo = 'Modificación manual'): void
    {
        $diferencia = $cantidadNueva - $cantidadAnterior;
        $accion = "Stock de '{$productoNombre}' modificado de {$cantidadAnterior} a {$cantidadNueva} unidades";
        
        if ($diferencia > 0) {
            $accion .= " (+{$diferencia})";
        } else {
            $accion .= " ({$diferencia})";
        }
        
        self::log($usuario, $accion, 'productos', [
            'producto' => $productoNombre,
            'stock_anterior' => $cantidadAnterior,
            'stock_nuevo' => $cantidadNueva,
            'diferencia' => $diferencia,
            'motivo' => $motivo,
        ]);
    }
}
