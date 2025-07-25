<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PedidoItem extends Model
{
    protected $fillable = [
        'pedido_id',
        'producto_id',
        'cantidad',
        'precio_unit_l1',
        'subtotal'
    ];

    protected $casts = [
        'precio_unit_l1' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /** @return BelongsTo<Pedido> */
    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }

    /** @return BelongsTo<Producto> */
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }
}
