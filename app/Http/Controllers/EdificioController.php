<?php
namespace App\Http\Controllers;

use App\Models\Edificio;
use Illuminate\Http\Request;

class EdificioController extends Controller
{
    public function index()
    {
        return response()->json(
            Edificio::with('empresa')->get()
        );
    }

    public function store(Request $request)
    {
        $edificio = Edificio::create($request->all());
        return response()->json($edificio, 201);
    }

    public function show($id)
    {
        return response()->json(
            Edificio::with('empresa')->findOrFail($id)
        );
    }

    public function update(Request $request, $id)
    {
        $edificio = Edificio::findOrFail($id);
        $edificio->update($request->all());
        return response()->json($edificio);
    }

    public function destroy($id)
    {
        Edificio::findOrFail($id)->delete();
        return response()->json(['mensaje' => 'Edificio eliminado']);
    }
}
