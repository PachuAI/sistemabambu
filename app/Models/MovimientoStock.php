<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovimientoStock extends Model
{
    const UPDATED_AT = null; // Solo usamos created_at, no updated_at
    
    protected $fillable = [
        'producto_id',
        'pedido_id',
        'cantidad',
        'motivo',  
        'observaciones',
        'created_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /** @return BelongsTo<Producto> */
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }

    /** @return BelongsTo<Pedido> */
    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }
}
