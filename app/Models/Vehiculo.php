<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $fillable = [
        'nombre',
        'capacidad_bultos',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
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
            ->porFecha($fecha)
            ->sum('bultos_asignados');
            
        return $this->capacidad_bultos - $bultosAsignados;
    }
}
