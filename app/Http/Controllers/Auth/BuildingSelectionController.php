<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EspacioRol;
use App\Models\Edificio;
use Illuminate\Support\Facades\Validator;
use App\Services\MenuPermisoService;

class BuildingSelectionController extends Controller
{
    public function select(Request $request)
    {
        $usuario = $request->user();

        $validator = Validator::make($request->all(), [
            'cod_edificio' => 'required'
        ], [
            'cod_edificio.required' => 'Debe seleccionar un edificio.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'title' => 'Error de validación',
                'description' => $validator->errors()->first()
            ], 422);
        }

        //Verificar que el edificio exista
        $edificio = Edificio::find($request->cod_edificio);
        if (!$edificio) {
            return response()->json([
                'code' => 422,
                'title' => 'Edificio inválido',
                'description' => 'El edificio seleccionado no existe.'
            ], 422);
        }

        //Verificar que el usuario tenga acceso a este edificio
        $espacioRoles = EspacioRol::with('rol')
            ->where('cod_usuario', $usuario->cod_usuario)
            ->where('cod_edificio', $request->cod_edificio)
            ->get();

        if ($espacioRoles->isEmpty()) {
            return response()->json([
                'code' => 403,
                'title' => 'Acceso denegado',
                'description' => 'El usuario no tiene acceso a este edificio.'
            ], 403);
        }

        //Seleccionar rol de mayor prioridad (1 = mayor)
        $espacioRol = $espacioRoles->sortBy('rol.prioridad')->first();

        $codRol = $espacioRol->rol->cod_rol;
        $menus = MenuPermisoService::obtenerPorRol($codRol);

        return response()->json([
            'codEdificio' => $edificio->cod_edificio,
            'edificio' => [
                'nombre' => $edificio->nombre,
                'direccion' => $edificio->direccion,
                'rutaLogo' => $edificio->ruta_logo,
            ],
            'rol' => [
                'codRol' => $espacioRol->rol->cod_rol,
                'descripcion' => $espacioRol->rol->descripcion,
                'prioridad' => $espacioRol->rol->prioridad,
            ],
            'menus' => $menus
        ]);
    }
}
