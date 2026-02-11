<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuRolController extends Controller
{
    public function assign(Request $request)
    {
        $data = $request->validate([
            'cod_usuario' => 'required|exists:usuarios,cod_usuario',
            'cod_rol'     => 'required|exists:roles,cod_rol',
            'activo'      => 'boolean',
        ]);

        $usuario = Usuario::findOrFail($data['cod_usuario']);

        $usuario->roles()->syncWithoutDetaching([
            $data['cod_rol'] => ['activo' => $data['A'] ?? true]
        ]);

        return response()->json([
            'message' => 'Rol asignado correctamente'
        ]);
    }

    public function remove(Request $request)
    {
        $data = $request->validate([
            'cod_usuario' => 'required|exists:usuarios,cod_usuario',
            'cod_rol'     => 'required|exists:roles,cod_rol',
        ]);

        $usuario = Usuario::findOrFail($data['cod_usuario']);
        $usuario->roles()->detach($data['cod_rol']);

        return response()->json([
            'message' => 'Rol eliminado del usuario'
        ]);
    }
}
