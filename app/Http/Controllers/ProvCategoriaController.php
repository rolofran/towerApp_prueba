<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProvCategoria;

class ProvCategoriaController extends Controller
{
    public function index()
    {
        return ProvCategoria::with(relations: ['proveedor.persona', 'categoria'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_proveedor' => 'required|exists:proveedores,id_proveedor',
            'id_categoria' => 'required|exists:categorias,id_categoria'
        ]);

        $relacion = ProvCategoria::create([
            'id_proveedor' => $request->id_proveedor,
            'id_categoria' => $request->id_categoria,
            'estado' => true
        ]);

        return response()->json(
            $relacion->load(['proveedor.persona', 'categoria']),
            201
        );
    }

    public function destroy($id)
    {
        $relacion = ProvCategoria::findOrFail($id);
        $relacion->update(['estado' => false]);

        return response()->json(['message' => 'Relación desactivada']);
    }
}
