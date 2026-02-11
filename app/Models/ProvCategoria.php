<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProvCategoria extends Model
{
    protected $table = 'prov_categorias';
    protected $primaryKey = 'id_prov_categoria';

    protected $fillable = [
        'id_proveedor',
        'id_categoria',
        'estado'
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor', 'id_proveedor');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }
}
