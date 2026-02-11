<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentPersona extends Model
{
    use HasFactory;
    protected $fillable = [
        'cod_persona',
        'tip_documento',
        'nro_documento',
        'fec_vencimiento',
        'por_defecto'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'cod_persona', 'cod_persona');
    }
}
