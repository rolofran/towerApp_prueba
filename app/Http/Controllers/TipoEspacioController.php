<?php
namespace App\Http\Controllers;

use App\Models\TipoEspacio;
use Illuminate\Http\Request;

class TipoEspacioController extends Controller
{
    public function index()
    {
        return response()->json(TipoEspacio::all());
    }

    public function store(Request $request)
    {
        return response()->json(
            TipoEspacio::create($request->all()),
            201
        );
    }

    public function show($id)
    {
        return response()->json(TipoEspacio::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $tipo = TipoEspacio::findOrFail($id);
        $tipo->update($request->all());
        return response()->json($tipo);
    }

    public function destroy($id)
    {
        TipoEspacio::findOrFail($id)->delete();
        return response()->json(['mensaje' => 'Tipo de espacio eliminado']);
    }
}
