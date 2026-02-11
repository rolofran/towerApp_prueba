<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActividadDetalle extends Model
{
    use HasFactory;

    protected $table = 'actividad_detalle';
    protected $primaryKey = 'id_actividad_det';

    protected $fillable = [
        'id_actividad_cab',
        'fecha_evento',
        'hora_desde',
        'hora_hasta',
        'observacion'
    ];

    protected $casts = [
        'fecha_evento' => 'date',
        'hora_desde' => 'datetime:H:i',
        'hora_hasta' => 'datetime:H:i'
    ];

    public function cabecera()
    {
        return $this->belongsTo(
            ActividadCabecera::class,
            'id_actividad_cab'
        );
    }
}
