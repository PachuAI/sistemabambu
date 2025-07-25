<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $fillable = [
        'nombre',
        'patente',
        'capacidad_bultos',
        'estado',
        'descripcion'
    ];

    protected $casts = [
        'estado' => 'string',
    ];

    public function scopeActivos($query)
    {
        return $query->where('estado', 'disponible');
    }

    public function scopeDisponibles($query)
    {
        return $query->where('estado', 'disponible');
    }

    public function repartos()
    {
        return $this->hasMany(Reparto::class);
    }

    /**
     * Calcula bultos disponibles para una fecha específica
     */
    public function bultosDisponibles($fecha)
    {
        $bultosAsignados = $this->repartos()
            ->where('fecha_reparto', $fecha)
            ->sum('bultos_asignados');
            
        return $this->capacidad_bultos - $bultosAsignados;
    }
}
