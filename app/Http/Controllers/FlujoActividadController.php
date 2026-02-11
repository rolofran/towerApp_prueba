<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FlujoActividadController extends Controller
{
    public function cambiarEstado(
        Request $request,
        $idActividadCab,
        FlujoActividadService $service
    ) {
        $data = $request->validate([
            'id_estado'   => 'required|exists:estados,id_estado',
            'observacion' => 'required|string'
        ]);

        return $service->cambiarEstado(
            $idActividadCab,
            $data['id_estado'],
            $data['observacion'],
            auth()->user()->cod_usuario
        );
    }
}

