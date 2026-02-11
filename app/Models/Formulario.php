<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formulario extends Model
{
    protected $table = 'formularios';
    protected $primaryKey = 'cod_form';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'cod_form',
        'cod_menu',
        'descripcion',
        'estado'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'cod_menu');
    }
}