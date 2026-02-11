<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        return Categoria::with(relations: ['proveedores.persona'])->orderBy('nom_categoria')->get();
    }

    public function show($id)
    {
        return Categoria::findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom_categoria' => 'required|string|max:150',
            'estado' => 'sometimes|boolean'
        ]);

        return response()->json(
            Categoria::create($data),
            201
        );
    }

    public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);

        $data = $request->validate([
            '' => 'sometimes|string|max:150',
            'estado' => 'sometimes|boolean'
        ]);

        $categoria->update($data);

        return $categoria;
    }

    public function destroy($id)
    {
        Categoria::findOrFail($id)->delete();

        return response()->json([
            'mensaje' => 'Categoría eliminada'
        ]);
    }
}
