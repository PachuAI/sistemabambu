<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Cliente extends Model
{
    use SoftDeletes, Searchable;

    protected $table = 'clientes';
    protected $fillable = [
        'direccion',
        'telefono',
        'nombre',
        'ciudad_id',
        'email',
    ];

    /** @return BelongsTo<Ciudad,Cliente> */
    public function ciudad(): BelongsTo
    {
        return $this->belongsTo(Ciudad::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
        ];
    }
}
