<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provincia extends Model
{
    protected $fillable = ['nombre', 'codigo'];

    /** @return HasMany<Ciudad> */
    public function ciudades(): HasMany
    {
        return $this->hasMany(Ciudad::class);
    }
}
