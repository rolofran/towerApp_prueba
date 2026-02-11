<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UsuRol extends Pivot
{
    use HasFactory;

    protected $table = 'usu_roles';

    public $incrementing = false;

    protected $fillable = [
        'cod_usuario',
        'cod_rol',
        'activo',
    ];
}
