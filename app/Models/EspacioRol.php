<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EspacioRol extends Model
{
    protected $table = 'espacio_roles';

    protected $primaryKey = 'id';
    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'cod_edificio',
        'id_unidad_espacio',
        'cod_rol',
        'cod_usuario',
    ];

    /* ======================
       RELACIONES
    ====================== */

    public function edificio()
    {
        return $this->belongsTo(
            Edificio::class,
            'cod_edificio',
            'cod_edificio'
        );
    }

    public function unidadEspacio()
    {
        return $this->belongsTo(
            UnidadEspacio::class,
            'id_unidad_espacio',
            'id_unidad_espacio'
        );
    }

    public function rol()
    {
        return $this->belongsTo(
            Rol::class,
            'cod_rol',
            'cod_rol'
        );
    }

    public function usuario()
    {
        return $this->belongsTo(
            Usuario::class,
            'cod_usuario',
            'cod_usuario'
        );
    }
}
