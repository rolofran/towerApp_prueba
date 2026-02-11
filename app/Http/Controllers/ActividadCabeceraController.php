<?php

namespace App\Http\Controllers;
use App\Services\ActividadService;
use Illuminate\Http\Request;


class ActividadCabeceraController extends Controller
{
    public function index()
    {
        return ActividadCabecera::with([
            'frecuencia',
            'detalles',
            'ultimoFlujo.estado'
        ])->get();
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
