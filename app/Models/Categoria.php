<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria';

    protected $fillable = [
        'nom_categoria',
        'estado'
    ];

    public function provCategorias()
    {
        return $this->hasMany(ProvCategoria::class, 'id_categoria', 'id_categoria');
    }

    public function proveedores()
    {
        return $this->belongsToMany(
            Proveedor::class,
            'prov_categorias',
            'id_categoria',
            'id_proveedor'
        )->withPivot('estado')->withTimestamps();
    }
}
