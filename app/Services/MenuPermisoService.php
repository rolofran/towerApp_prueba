<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class MenuPermisoService
{
    public static function obtenerPorRol($codRol)
    {
        $rows = DB::table('menu as m')
            ->join('formularios as f', 'f.cod_menu', '=', 'm.cod_menu')
            ->join('permisos as p', 'p.cod_form', '=', 'f.cod_form')
            ->where('p.cod_rol', $codRol)
            ->where('m.estado', true)
            ->where('f.estado', true)
            ->where('p.estado', true)
            ->where(function ($q) {
                $q->where('p.ind_insertar', true)
                  ->orWhere('p.ind_actualizar', true)
                  ->orWhere('p.ind_borrar', true)
                  ->orWhere('p.ind_consultar', true);
            })
            ->select(
                'm.cod_menu',
                'm.titulo as menu',
                'f.cod_form',
                'f.descripcion as formulario',
                'p.ind_insertar',
                'p.ind_actualizar',
                'p.ind_borrar',
                'p.ind_consultar'
            )
            ->orderBy('m.cod_menu')
            ->orderBy('f.cod_form')
            ->get();

        return self::estructurar($rows);
    }

    private static function estructurar($rows)
    {
        $menu = [];

        foreach ($rows as $r) {
            if (!isset($menu[$r->cod_menu])) {
                $menu[$r->cod_menu] = [
                    'codMenu' => $r->cod_menu,
                    'titulo'  => $r->menu,
                    'formularios' => []
                ];
            }

            $menu[$r->cod_menu]['formularios'][] = [
                'codForm'    => $r->cod_form,
                'descripcion'=> $r->formulario,
                'insertar'   => (bool) $r->ind_insertar,
                'actualizar' => (bool) $r->ind_actualizar,
                'borrar'     => (bool) $r->ind_borrar,
                'consultar'  => (bool) $r->ind_consultar,
            ];
        }

        return array_values($menu);
    }
}
