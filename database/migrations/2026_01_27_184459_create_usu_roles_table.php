<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usu_roles', function (Blueprint $table) {
            $table->string('cod_usuario', 20);
            $table->integer('cod_rol');
            $table->boolean('activo')->default(true);
            $table->timestamps();

            // Clave primaria compuesta
            $table->primary(['cod_usuario', 'cod_rol']);

            // Claves foráneas
            $table->foreign('cod_usuario')
                  ->references('cod_usuario')
                  ->on('usuarios')
                  ->onDelete('cascade');

            $table->foreign('cod_rol')
                  ->references('cod_rol')
                  ->on('roles')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usu_roles');
    }
};
