<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'personas';

    protected $fillable = [
        'cod_persona',
        'nombre',
        'apellido',
        'fec_nacimiento',
        'estado'
    ];

    public function identificaciones()
    {
        return $this->hasMany(IdentPersona::class, 'cod_persona', 'cod_persona');
    }

    public function telefonos()
    {
        return $this->hasMany(TelefPersona::class, 'cod_persona', 'cod_persona');
    }

    public function direcciones()
    {
        return $this->hasMany(DirecPersona::class, 'cod_persona', 'cod_persona');
    }

    public function correos()
    {
        return $this->hasMany(CorreoPersona::class, 'cod_persona', 'cod_persona');
    }
    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'cod_persona', 'cod_persona');
    }

    public function empresas()
    {
        return $this->hasMany(Empresa::class, 'cod_persona', 'cod_persona');
    }

    public function proveedor()
    {
        return $this->hasOne( Proveedor::class, 'cod_persona', 'cod_persona');
    }

}
