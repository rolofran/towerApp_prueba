<?php

namespace App\Http\Controllers;

use App\Models\Formulario;
use Illuminate\Http\Request;

class FormularioController extends Controller
{
    public function index()
    {
        return Formulario::with('menu')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'cod_form' => 'required|string|unique:formularios,cod_form',
            'cod_menu' => 'required|string|exists:menu,cod_menu',
            'descripcion' => 'required|string',
            'estado' => 'boolean'
        ]);

        return Formulario::create($request->all());
    }

    public function show($cod_form)
    {
        return Formulario::with('menu')->findOrFail($cod_form);
    }

    public function update(Request $request, $cod_form)
    {
        $formulario = Formulario::findOrFail($cod_form);

        $request->validate([
            'cod_menu' => 'required|string|exists:menu,cod_menu',
            'descripcion' => 'required|string',
            'estado' => 'boolean'
        ]);

        $formulario->update($request->all());
        return $formulario;
    }

    public function destroy($cod_form)
    {
        Formulario::findOrFail($cod_form)->delete();
        return response()->json(['mensaje' => 'Formulario eliminado']);
    }
}
