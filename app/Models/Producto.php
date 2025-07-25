<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Producto extends Model
{
    use SoftDeletes, Searchable;

    protected $table = 'productos';
    protected $fillable = [
        'nombre',
        'sku',
        'precio_base_l1',
        'stock_actual',
        'es_combo',
        'descripcion',
        'peso_kg',
    ];

    protected $casts = [
        'precio_base_l1' => 'decimal:2',
        'peso_kg' => 'decimal:3',
        'es_combo' => 'boolean',
    ];

    /**
     * Calcula cuántos bultos representa este producto según su peso
     * 5kg = 1 bulto (estándar de bidón)
     */
    public function getBultosAttribute(): float
    {
        return round($this->peso_kg / 5, 2);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'sku' => $this->sku,
            'stock_actual' => $this->stock_actual,
        ];
    }
}
