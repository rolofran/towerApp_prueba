<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAcceso extends Model
{
    protected $table = 'log_accesos';
    protected $primaryKey = 'id_log';
    public $timestamps = false;

    protected $fillable = ['cod_usuario','fecha_login','fecha_logout','ip'];
}
