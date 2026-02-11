<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;


class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'cod_usuario';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'cod_usuario',
        'cod_persona',
        'password',
        'estado',
    ];

    protected $hidden = [
        'password',
    ];

    // Relación con persona
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'cod_persona', 'cod_persona');
    }

    // Espacios a los que tiene acceso el usuario
    public function espacioRoles()
    {
        return $this->hasMany(EspacioRol::class, 'cod_usuario', 'cod_usuario');
    }

    // Edificios a los que puede acceder (a través de espacio_roles)
    public function edificios()
    {
        return $this->belongsToMany(
            Edificio::class,
            'espacio_roles',
            'cod_usuario',   // FK espacio_roles -> usuario
            'cod_edificio'   // FK espacio_roles -> edificio
        )->distinct();
    }
}