<?php

namespace App\Http\Controllers;

use App\Models\Prioridad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PrioridadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Prioridad::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info("Intentando guardar una prioridad");
        $request->validate([
            'descripcion' => 'required|string',
        ]);
        
        $prioridad = Prioridad::create([
            'descripcion' => $request->descripcion
        ]);
        return response()->json($prioridad, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $prioridad = Prioridad::findOrFail($id);
        return response()->json($prioridad,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $prioridad = Prioridad::findOrFail(id: $id);
        $prioridad->update(attributes: $request->all());
        return response()->json(data: $prioridad,status: 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prioridad = Prioridad::findOrFail($id);
        $prioridad->delete();
        return response()->json(data: ['message' => 'Prioridad eliminada correctamente'],status: 200);
    }
}
