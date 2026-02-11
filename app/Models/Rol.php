<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $primaryKey = 'cod_rol';
    public $incrementing = true;

    protected $fillable = [
        'cod_rol',
        'descripcion',
        'prioridad',
        'activo',
    ];

}
