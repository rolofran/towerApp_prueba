<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActividadCabecera;
use App\Services\ActividadService;
use App\Models\Estado;

class ActividadCabeceraController extends Controller
{
    public function index()
    {
        $actividades = ActividadCabecera::with([
            'frecuencia:id_frecuencia,descripcion',
            'prioridad:id_prioridad,descripcion',
            'unidadEspacio:id_unidad_espacio,descripcion',
            'detalles:id_actividad_det,id_actividad_cab,fecha_evento,hora_desde,hora_hasta',
            'ultimoFlujo.estado:id_estado,descripcion'
        ])->get();

        $resultado = collect();

        foreach ($actividades as $a) {
            foreach ($a->detalles as $d) {
                $resultado->push([
                    'id_actividad'  => $a->id_actividad_cab,
                    'id_detalle'    => $d->id_actividad_det,
                    'titulo'        => $a->titulo,
                    'descripcion'   => $a->descripcion,
                    'prioridad'     => $a->prioridad->descripcion ?? null,
                    'frecuencia'    => $a->frecuencia->descripcion ?? null,
                    'unidad_espacio'=> $a->unidadEspacio->descripcion ?? null,
                    'estado'        => $a->ultimoFlujo->estado->descripcion ?? null,
                    'fecha_evento'  => $d->fecha_evento,
                    'hora_desde'    => $d->hora_desde,
                    'hora_hasta'    => $d->hora_hasta,
                ]);
            }
        }

        return response()->json($resultado);
    }



    public function store(Request $request, ActividadService $service)
    {
        $data = $request->validate([
            'titulo'            => 'required',
            'descripcion'       => 'required',
            'id_frecuencia'     => 'required|exists:frecuencias,id_frecuencia',
            'cant_frecuencia'   => 'required|integer|min:1',
            'id_prioridad'      => 'required',
            'id_unidad_espacio' => 'required',
            'id_categoria'      => 'required',
            'tip_actividad'     => 'required'
        ]);

        return $service->crearActividad($data, auth()->user()->cod_usuario);
    }

    public function update(Request $request, $id)
    {
        $actividad = ActividadCabecera::with('ultimoFlujo.estado')
        ->findOrFail($id);

        $estado = strtolower(
            $actividad->ultimoFlujo->estado->descripcion ?? ''
        );

        if ($estado === 'pendiente') {
             return response()->json([
            'message' => 'Solo se permite editar actividades en estado Pendiente'
           ], 403);
       }

        $data = $request->validate([
            'titulo'            => 'required',
            'descripcion'       => 'required',
            'id_frecuencia'     => 'required|exists:frecuencias,id_frecuencia',
            'cant_frecuencia'   => 'required|integer|min:1',
            'id_prioridad'      => 'required',
            'id_unidad_espacio' => 'required',
            'id_categoria'      => 'required',
            'tip_actividad'     => 'required'
        ]);

        $actividad->update($data);

        return response()->json([
            'message' => 'Actividad actualizada correctamente',
            'data' => $actividad->fresh([
                'frecuencia',
                'prioridad',
                'unidadEspacio',
                'categoria',
                'ultimoFlujo.estado'
            ])
        ]);
    }

}
