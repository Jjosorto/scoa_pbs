<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Modelo extends Model
{
    use HasFactory;
    public function marca():BelongsTo{
        return $this->belongsTo(Marca::class,'marca_id');
    }
    public function categoria(): BelongsTo{
        return $this->belongsTo(Categoria::class,'categoria_id');
    }
}
