<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;

class FlujoActividadService
{
    public function cambiarEstado(
        int $idActividadCab,
        int $idEstado,
        string $observacion,
        string $codUsuario
    ) {
        return DB::transaction(function () use (
            $idActividadCab,
            $idEstado,
            $observacion,
            $codUsuario
        ) {
            $ultimo = FlujoActividad::where('id_actividad_cab', $idActividadCab)
                ->latest('fecha_mov')
                ->first();

            $estado = Estado::findOrFail($idEstado);

            return FlujoActividad::create([
                'id_actividad_cab' => $idActividadCab,
                'id_estado'        => $estado->id_estado,
                'cod_usuario'      => $codUsuario,
                'fecha_mov'        => now(),
                'observacion'      => $observacion,
                'estado_ant'       => $ultimo?->estado,
                'estado'           => $estado->descripcion
            ]);
        });
    }
}
