<?php

namespace App\Http\Controllers;

use App\Models\EspacioRol;
use Illuminate\Http\Request;

class EspacioRolController extends Controller
{
    public function index()
    {
        return EspacioRol::with([
            'edificio',
            'unidadEspacio',
            'rol',
            'usuario'
        ])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'cod_edificio' => 'required|integer|exists:edificios,cod_edificio',
            'id_unidad_espacio' => 'required|integer|exists:unidad_espacios,id_unidad_espacio',
            'cod_rol' => 'required|integer|exists:roles,cod_rol',
            'cod_usuario' => 'required|string|exists:usuarios,cod_usuario',
        ]);

        $espacioRol = EspacioRol::create($request->all());

        return response()->json($espacioRol, 201);
    }

    public function show($id)
    {
        return EspacioRol::with([
            'edificio',
            'unidadEspacio',
            'rol',
            'usuario'
        ])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $espacioRol = EspacioRol::findOrFail($id);

        $espacioRol->update(
            $request->only([
                'cod_edificio',
                'id_unidad_espacio',
                'cod_rol',
                'cod_usuario',
            ])
        );

        return $espacioRol;
    }

    public function destroy($id)
    {
        EspacioRol::findOrFail($id)->delete();

        return response()->json([
            'mensaje' => 'Asignación eliminada'
        ]);
    }
}
