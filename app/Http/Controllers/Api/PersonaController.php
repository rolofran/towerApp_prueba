<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonaController extends Controller
{
    public function index()
    {
        $personas = Persona::with([
            'identificaciones',
            'telefonos',
            'direcciones',
            'correos'
        ])->get();

        return response()->json($personas);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $persona = Persona::create(
                $request->only([
                    'cod_persona',
                    'nombre',
                    'apellido',
                    'fec_nacimiento'
                ])
            );

            if ($request->has('identificadores')) {
                $persona->identificadores()->createMany(
                    $request->identificadores
                );
            }

            if ($request->has('telefonos')) {
                $persona->telefonos()->createMany(
                    $request->telefonos
                );
            }

            if ($request->has('direcciones')) {
                $persona->direcciones()->createMany(
                    $request->direcciones
                );
            }

            if ($request->has('correos')) {
                $persona->correos()->createMany(
                    $request->correos
                );
            }

            DB::commit();

            return response()->json($persona->load([
                'identificadores',
                'telefonos',
                'direcciones',
                'correos'
            ]), 201);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error al crear persona',
                'detalle' => $e->getMessage()
            ], 500);
        }
    }
}
