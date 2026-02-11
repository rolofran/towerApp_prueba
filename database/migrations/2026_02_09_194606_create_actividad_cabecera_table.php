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
        Schema::create('actividad_cabecera', function (Blueprint $table) {
            $table->id('id_actividad_cab');
            $table->string('titulo');
            $table->string('descripcion');
            $table->unsignedBigInteger('id_frecuencia');
            $table->unsignedBigInteger('id_prioridad');
            $table->unsignedBigInteger('id_unidad_espacio');
            $table->unsignedBigInteger('id_categoria');
            $table->string('tip_actividad');
            $table->unsignedBigInteger('cant_frecuencia');

            $table->foreign('id_frecuencia')
                ->references('id_frecuencia')
                ->on('frecuencias');

            $table->foreign('id_prioridad')
                ->references('id_prioridad')
                ->on('prioridades');

            $table->foreign('id_unidad_espacio')
                ->references('id_unidad_espacio')
                ->on('unidad_espacios');

            $table->foreign('id_categoria')
                ->references('id_categoria')
                ->on('categorias');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividad_cabecera');
    }
};
