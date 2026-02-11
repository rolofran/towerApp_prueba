<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActividadCabecera extends Model
{
    use HasFactory;

    protected $table = 'actividad_cabecera';

    protected $primaryKey = 'id_actividad_cab';

    protected $fillable = [
        'titulo',
        'descripcion',
        'id_frecuencia',
        'id_prioridad',
        'id_unidad_espacio',
        'id_categoria',
        'tip_actividad',
        'cant_frecuencia'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function frecuencia()
    {
        return $this->belongsTo(Frecuencia::class, 'id_frecuencia');
    }

    public function prioridad()
    {
        return $this->belongsTo(Prioridad::class, 'id_prioridad');
    }

    public function unidadEspacio()
    {
        return $this->belongsTo(UnidadEspacio::class, 'id_unidad_espacio');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public function detalles()
    {
        return $this->hasMany(
            ActividadDetalle::class,
            'id_actividad_cab'
        );
    }
    public function flujos()
    {
        return $this->hasMany(FlujoActividad::class, 'id_actividad_cab');
    }

    public function ultimoFlujo()
    {
        return $this->hasOne(FlujoActividad::class, 'id_actividad_cab')
            ->latest('fecha_mov');
    }
}
