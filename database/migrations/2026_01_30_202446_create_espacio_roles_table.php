<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('espacio_roles', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('cod_edificio');
            $table->foreign('cod_edificio')
                  ->references('cod_edificio')
                  ->on('edificios')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('id_unidad_espacio');
            $table->foreign('id_unidad_espacio')
                  ->references('id_unidad_espacio')
                  ->on('unidad_espacios')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('cod_rol');
            $table->foreign('cod_rol')
                  ->references('cod_rol')
                  ->on('roles')
                  ->onDelete('restrict');

            $table->string('cod_usuario');
            $table->timestamps();

            // Evita duplicados lógicos
            $table->unique(
                ['cod_edificio','id_unidad_espacio','cod_rol'],
                'espacios_roles_unico'
            );

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('espacio_roles');
    }
};
