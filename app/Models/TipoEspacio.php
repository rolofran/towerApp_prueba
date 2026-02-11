<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEspacio extends Model
{
    protected $table = 'tipo_espacios';
    protected $primaryKey = 'id_espacio';
    protected $fillable = ['descripcion'];
}
