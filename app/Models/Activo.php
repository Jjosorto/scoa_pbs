<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Activo extends Model
{
    use HasFactory;
    public function producto(): BelongsTo{
        return $this->belongsTo(Producto::class,'producto_id');
    }
    public function cliente(): BelongsTo{
        return $this->belongsTo(Cliente::class,'cliente_id');
    }
    public function departamento(): BelongsTo{
        return $this->belongsTo(Departamento::class,'departamento_id');
    }

    public function mantenimientos():HasMany{return $this->hasMany(Mantenimiento_activo::class);
    }
}
