<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    use HasFactory;

    public function modelos(): BelongsTo{
        return $this->belongsTo(Modelo::class,'modelo_id');
    }

    public function activo():HasMany{return $this->hasMany(Activo::class);
    }

}
