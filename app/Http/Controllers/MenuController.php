<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        return Menu::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'cod_menu' => 'required|string|unique:menu,cod_menu',
            'titulo'   => 'required|string',
            'estado'   => 'boolean'
        ]);

        return Menu::create($request->all());
    }

    public function show($cod_menu)
    {
        return Menu::findOrFail($cod_menu);
    }

    public function update(Request $request, $cod_menu)
    {
        $menu = Menu::findOrFail($cod_menu);

        $request->validate([
            'titulo' => 'required|string',
            'estado' => 'boolean'
        ]);

        $menu->update($request->all());
        return $menu;
    }

    public function destroy($cod_menu)
    {
        Menu::findOrFail($cod_menu)->delete();
        return response()->json(['mensaje' => 'Menú eliminado']);
    }
}
