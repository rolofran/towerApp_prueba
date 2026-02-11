<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadEspacio extends Model
{
    protected $table = 'unidad_espacios';
    protected $primaryKey = 'id_unidad_espacio';

    protected $fillable = [
        'cod_edificio',
        'id_espacio',
        'nro_piso',
        'nro_departamento',
        'descripcion',
        'estado'
    ];

     public function edificio()
    {
        return $this->belongsTo(Edificio::class, 'cod_edificio');
    }

    public function tipoEspacio()
    {
        return $this->belongsTo(TipoEspacio::class, 'id_espacio');
    }
}
