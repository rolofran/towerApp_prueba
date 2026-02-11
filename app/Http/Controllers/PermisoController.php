<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    public function index()
    {
        return Permiso::with('formulario')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'cod_rol'  => 'required|integer|exists:roles,cod_rol',
            'cod_form' => 'required|string|exists:formularios,cod_form',

            'ind_insertar'   => 'boolean',
            'ind_actualizar' => 'boolean',
            'ind_borrar'     => 'boolean',
            'ind_consultar'  => 'boolean',
            'estado'         => 'boolean'
        ]);

        // evita duplicado rol + formulario
        $permiso = Permiso::updateOrCreate(
            [
                'cod_rol'  => $request->cod_rol,
                'cod_form' => $request->cod_form
            ],
            $request->all()
        );

        return $permiso;
    }

    public function show($id)
    {
        return Permiso::with('formulario')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $permiso = Permiso::findOrFail($id);

        $request->validate([
            'ind_insertar'   => 'boolean',
            'ind_actualizar' => 'boolean',
            'ind_borrar'     => 'boolean',
            'ind_consultar'  => 'boolean',
            'estado'         => 'boolean'
        ]);

        $permiso->update($request->all());
        return $permiso;
    }

    public function destroy($id)
    {
        Permiso::findOrFail($id)->delete();
        return response()->json(['mensaje' => 'Permiso eliminado']);
    }
}
