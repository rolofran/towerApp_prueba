<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirecPersona extends Model
{
    use HasFactory;
    protected $fillable = [
        'cod_persona',
        'direccion',
        'por_defecto'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'cod_persona', 'cod_persona');
    }
}
