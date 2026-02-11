<?php
namespace App\Http\Controllers;

use App\Models\UnidadEspacio;
use Illuminate\Http\Request;

class UnidadEspacioController extends Controller
{
    public function index()
    {
        return response()->json(
            UnidadEspacio::with(['edificio','tipoEspacio'])->get()
        );
    }

    public function store(Request $request)
    {
        return response()->json(
            UnidadEspacio::create($request->all()),
            201
        );
    }

    public function show($id)
    {
        return response()->json(
            UnidadEspacio::with(['edificio','tipoEspacio'])->findOrFail($id)
        );
    }

    public function update(Request $request, $id)
    {
        $unidad = UnidadEspacio::findOrFail($id);
        $unidad->update($request->all());
        return response()->json($unidad);
    }

    public function destroy($id)
    {
        UnidadEspacio::findOrFail($id)->delete();
        return response()->json(['mensaje' => 'Unidad de espacio eliminada']);
    }

}
