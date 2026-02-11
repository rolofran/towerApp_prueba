<?php

namespace App\Http\Controllers;
use App\Models\Proveedor;
use App\Models\Persona;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Proveedor::with(relations: ['persona', 'provCategorias.categoria', 'categorias'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cod_persona' => 'required|string|unique:proveedores,cod_persona',
            'activo' => 'boolean',
        ]);

        $persona = Persona::where('cod_persona', $request->cod_persona)->first();

        if (!$persona) {
            return response()->json(['error' => 'La persona con el código proporcionado no existe.'], 404);
        }

        $proveedor = Proveedor::create([
            'cod_persona' => $request->cod_persona,
            'activo' => $request->activo ?? true,
        ]);

        return response()->json($proveedor->load('persona'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $proveedor = Proveedor::findOrFail(id: $id);
        return response()->json($proveedor->load('persona'),200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'activo' => 'boolean',
        ]);
        $persona = Persona::where('cod_persona', $request->cod_persona)->first();
        if (!$persona) {
            return response()->json(['error' => 'La persona con el código proporcionado no existe.'], 404);
        }
        $proveedor = Proveedor::find($id);
        if (!$proveedor) {
            return response()->json(['error' => 'Proveedor no encontrado.'], 404);
        }
        $proveedor->update($request->only('activo'));
        return response()->json($proveedor->load('persona'), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $proveedor = Proveedor::find($id);
        if (!$proveedor) {
            return response()->json(['error' => 'Proveedor no encontrado.'], 404);
        }
        $proveedor->delete();
        return response()->json($proveedor->load('persona'),200);
    }
}
