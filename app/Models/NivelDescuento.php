<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NivelDescuento extends Model
{
    protected $table = 'niveles_descuento';
    
    protected $fillable = [
        'nombre',
        'monto_min',
        'porcentaje',
    ];

    protected $casts = [
        'monto_min' => 'decimal:2',
        'porcentaje' => 'decimal:2',
    ];
}
