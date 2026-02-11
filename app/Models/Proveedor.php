<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';
    protected $primaryKey = 'id_proveedor';
    protected $fillable = [
        'cod_persona',
        'activo',
    ];

    public function persona()
    {
        return $this->belongsTo(
            Persona::class,
            'cod_persona',
            'cod_persona'
        );
    }

    public function provCategorias()
    {
        return $this->hasMany(ProvCategoria::class, 'id_proveedor', 'id_proveedor');
    }

    public function categorias()
    {
        return $this->belongsToMany(
            Categoria::class,
            'prov_categorias',
            'id_proveedor',
            'id_categoria'
        )->withPivot('estado')->withTimestamps();
    }

}
