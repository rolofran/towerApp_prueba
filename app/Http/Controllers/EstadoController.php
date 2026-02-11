<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Estado::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string',
            'menu_relacion' => 'required|string',
        ]);
        
        $estado = Estado::create([
            'descripcion' => $request->descripcion,
            'menu_relacion' => $request->menu_relacion,
        ]);
        return response()->json($estado, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $estado = Estado::findOrFail($id);
        return response()->json($estado,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $estado = Estado::findOrFail(id: $id);
        $estado->update(attributes: $request->all());
        return response()->json(data: $estado,status: 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $estado = Estado::findOrFail($id);
        $estado->delete();
        return response()->json(['message' => 'Estado eliminado correctamente'],200);
    }
}
