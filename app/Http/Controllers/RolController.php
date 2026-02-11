<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class RolController extends Controller
{
    public function index()
    {
        return Rol::all();
    }

    public function show($cod_rol)
    {
        return Rol::findOrFail($cod_rol);
    }

    public function store(Request $request)
    {
        return Rol::create(
            $request->validate([
                'cod_rol'     => 'required|integer|unique:roles,cod_rol',
                'descripcion' => 'required|string',
                'prioridad'   => 'required|integer',
                'activo'      => 'boolean',
            ])
        );
    }

    public function update(Request $request, $cod_rol)
    {
        $rol = Rol::findOrFail($cod_rol);

        $rol->update(
            $request->validate([
                'descripcion' => 'sometimes|string',
                'activo'      => 'sometimes|boolean',
            ])
        );

        return $rol;
    }

    public function destroy($cod_rol)
    {
        $rol = Rol::findOrFail($cod_rol);

        try {
            $rol->delete();
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'No se puede eliminar el rol porque está asignado a uno o más usuarios'
            ], 409);
        }

        return response()->noContent();
    }
}
