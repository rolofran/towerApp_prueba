<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActividadCabecera;
use App\Services\ActividadService;

class ActividadCabeceraController extends Controller
{
    public function index()
    {
        $actividades = ActividadCabecera::with([
            'frecuencia:id_frecuencia,descripcion',
            'prioridad:id_prioridad,descripcion',
            'unidadEspacio:id_unidad_espacio,descripcion',
            'categoria:id_categoria,nom_categoria',
            'detalles',
            'ultimoFlujo'
        ])->get();

        return response()->json($actividades);
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
}
