<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Frecuencia extends Model
{
    protected $table = 'frecuencias';

    protected $primaryKey = 'id_frecuencia';

    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'multiplicador'
    ];
}