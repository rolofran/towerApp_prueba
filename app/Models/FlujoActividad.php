<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlujoActividad extends Model
{
    use HasFactory;

    protected $table = "flujo_actividades";
    
    protected $primaryKey = "id_flujo_actividad";
    
    protected $fillable = [
        "id_actividad_cab",
        "id_estado",
        "cod_usuario",
        "fecha_mov",
        "observacion",
        "estado_ant",
    ];

    protected $casts = [
        'fecha_mov' => 'date',
    ];

    public function actividadCabecera()
    {
        return $this->belongsTo(
            ActividadCabecera::class,
            'id_actividad_cab'
        );
    }

    public function estado()
    {
        return $this->belongsTo(
            Estado::class,
            'id_estado',
            'id_estado'
        );
    }
}
