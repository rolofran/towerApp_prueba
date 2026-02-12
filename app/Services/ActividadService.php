<?php

namespace App\Services;
use App\Models\ActividadCabecera;
use App\Models\ActividadDetalle;
use App\Models\FlujoActividad;
use Illuminate\Support\Facades\DB;

class ActividadService
{
    public function crearActividad(array $data, string $codUsuario)
    {
        return DB::transaction(function () use ($data, $codUsuario) {

            $cabecera = ActividadCabecera::create($data);

            $frecuencia = $cabecera->frecuencia;
            $repeticiones = $cabecera->cant_frecuencia;
            $multiplicador = $frecuencia->multiplicador;

            $fecha = now();

            for ($i = 1; $i <= $repeticiones; $i++) {
                $fecha = $fecha->copy()->addDays($multiplicador);

                ActividadDetalle::create([
                    'id_actividad_cab' => $cabecera->id_actividad_cab,
                    'fecha_evento'     => $fecha
                ]);
            }

            FlujoActividad::create([
                'id_actividad_cab' => $cabecera->id_actividad_cab,
                'id_estado'        => 1,
                'cod_usuario'      => $codUsuario,
                'fecha_mov'        => now(),
                'observacion'      => 'Actividad creada',
                'estado_ant'       => null,
                'estado'           => 'CREADO'
            ]);

            return $cabecera->load('detalles', 'ultimoFlujo.estado');
        });
    }

    public function actualizarActividad($idActividad, array $data, $codUsuario)
    {
        $actividad = ActividadCabecera::findOrFail($idActividad);
    
        // Actualizar campos
        $actividad->update([
            'titulo'            => $data['titulo'],
            'descripcion'       => $data['descripcion'],
            'id_frecuencia'     => $data['id_frecuencia'],
            'cant_frecuencia'   => $data['cant_frecuencia'],
            'id_prioridad'      => $data['id_prioridad'],
            'id_unidad_espacio' => $data['id_unidad_espacio'],
            'id_categoria'      => $data['id_categoria'],
            'tip_actividad'     => $data['tip_actividad'],
        ]);
    
        return $actividad->load(['frecuencia', 'detalles', 'ultimoFlujo.estado']);
    }

}
