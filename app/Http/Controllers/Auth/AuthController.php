<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Usuario;
use App\Models\Edificio;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'cod_usuario' => 'required|string',
            'password' => 'required|string',
        ]);

        // Buscar usuario activo
        $usuario = Usuario::where('cod_usuario', $request->cod_usuario)
            ->where('estado', 'A')
            ->first();

        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        // Eliminar tokens anteriores
        $usuario->tokens()->delete();

        // Crear nuevo token
        $token = $usuario->createToken('auth_token')->plainTextToken;

        $expiresIn = 3600; // 1 hora
        $fechaCreacion = Carbon::now();
        $fechaExpiracion = $fechaCreacion->copy()->addSeconds($expiresIn);

        // Obtener edificios a los que el usuario tiene acceso a través de espacio_roles
        $buildings = $usuario->edificios()->distinct()->get()->map(function($edificio){
            return [
                'codEdificio' => $edificio->cod_edificio,
                'nombre' => $edificio->nombre,
                'direccion' => $edificio->direccion,
                'rutaLogo' => $edificio->ruta_logo,
            ];
        });

        $defaultBuilding = $buildings->first() ?? null;

        return response()->json([
            'user' => [
                'codUsuario' => $usuario->cod_usuario,
                'codPersona' => $usuario->cod_persona,
                'email' => $usuario->email ?? null,
                'nombre' => $usuario->persona->nombre ?? null,
                'apellido' => $usuario->persona->apellido ?? null,
                'avatar' => $usuario->avatar ?? null,
                'estado' => $usuario->estado === 'A' ? 'activo' : 'inactivo',
            ],
            'token' => [
                'accessToken' => $token,
                /*'refreshToken' => null, 
                'expiresIn' => $expiresIn,
                'tokenType' => 'Bearer',*/
            ],
            'session' => [
                'token' => $token,
                'codUsuario' => $usuario->cod_usuario,
                'fechaCreacion' => $fechaCreacion->timestamp * 1000,
                'fechaExpiracion' => $fechaExpiracion->timestamp * 1000,
            ],
            'requiresBuildingSelection' => $buildings->count() > 1,
            'buildings' => $buildings,
            'defaultBuilding' => $defaultBuilding,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesión cerrada correctamente'
        ]);
    }
}
