<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $primaryKey = 'cod_empresa';
    protected $fillable = ['cod_persona'];

    public function edificios()
    {
        return $this->hasMany(Edificio::class, 'cod_empresa');
    }
}
