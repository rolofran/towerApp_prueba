<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';
    protected $primaryKey = 'cod_menu';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'cod_menu',
        'titulo',
        'estado'
    ];
}
