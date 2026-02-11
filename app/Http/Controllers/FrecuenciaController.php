<?php

namespace App\Http\Controllers;

use App\Models\Frecuencia;
use Illuminate\Http\Request;

class FrecuenciaController extends Controller
{
    public function index()
    {
        return Frecuencia::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'multiplicador' => 'required|integer'
        ]);

        $frecuencia = Frecuencia::create($request->only([
            'descripcion',
            'multiplicador'
        ]));

        return response()->json($frecuencia, 201);
    }

    public function show($id)
    {
        return Frecuencia::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $frecuencia = Frecuencia::findOrFail($id);

        $request->validate([
            'descripcion' => 'required|string|max:255',
            'multiplicador' => 'required|integer'
        ]);

        $frecuencia->update($request->only([
            'descripcion',
            'multiplicador'
        ]));

        return response()->json($frecuencia);
    }

    public function destroy($id)
    {
        Frecuencia::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Frecuencia eliminada'
        ]);
    }
}
