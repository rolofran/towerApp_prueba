<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = 'permisos';

    protected $fillable = [
        'cod_rol',
        'cod_form',
        'ind_insertar',
        'ind_actualizar',
        'ind_borrar',
        'ind_consultar',
        'estado'
    ];

    public function formulario()
    {
        return $this->belongsTo(Formulario::class, 'cod_form');
    }
}