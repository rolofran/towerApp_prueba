<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edificio extends Model
{
    protected $primaryKey = 'cod_edificio';
    protected $fillable = ['cod_empresa','nombre','ruta_logo','direccion'];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'cod_empresa');
    }
}
