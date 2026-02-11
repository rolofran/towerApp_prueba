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
}
