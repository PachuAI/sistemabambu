<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ciudad extends Model
{
    protected $table = 'ciudades';
    protected $fillable = ['nombre', 'provincia_id', 'codigo_postal', 'latitud', 'longitud'];

    /** @return BelongsTo<Provincia> */
    public function provincia(): BelongsTo
    {
        return $this->belongsTo(Provincia::class);
    }

    /** @return HasMany<Cliente> */
    public function clientes(): HasMany
    {
        return $this->hasMany(Cliente::class);
    }
}
