<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mantenimiento_activo extends Model
{
    use HasFactory;
    
    public function activos(): BelongsTo{
        return $this->belongsTo(Activo::class,'activo_id');
    } 
}
