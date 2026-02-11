<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        return Usuario::with('roles')->get();
    }

    public function show($cod_usuario)
    {
        return Usuario::with('roles')->findOrFail($cod_usuario);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cod_usuario' => 'required|string|max:20|unique:usuarios,cod_usuario',
            'cod_persona' => 'required|string',
            'password'    => 'required|string|min:8',
            'estado'      => 'nullable|string',
        ]);

        $data['password'] = Hash::make($data['password']);

        return Usuario::create($data);
    }

    public function update(Request $request, $cod_usuario)
    {
        $usuario = Usuario::findOrFail($cod_usuario);

        $data = $request->validate([
            'cod_persona' => 'sometimes|string',
            'password'    => 'sometimes|string|min:6',
            'estado'      => 'sometimes|string',
        ]);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $usuario->update($data);

        return $usuario->load('roles');
    }

    public function destroy($cod_usuario)
    {
        Usuario::findOrFail($cod_usuario)->delete();
        return response()->noContent();
    }
}
