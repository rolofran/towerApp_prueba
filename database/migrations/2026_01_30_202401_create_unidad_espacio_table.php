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
        Schema::create('unidad_espacios', function (Blueprint $table) {
            $table->id('id_unidad_espacio');

            $table->unsignedBigInteger('cod_edificio');
            $table->foreign('cod_edificio')
                  ->references('cod_edificio')
                  ->on('edificios')
                  ->onDelete('restrict');

            $table->unsignedBigInteger('id_espacio');
            $table->foreign('id_espacio')
                  ->references('id_espacio')
                  ->on('tipo_espacios')
                  ->onDelete('restrict');

            $table->string('nro_piso');
            $table->string('nro_departamento')->nullable();
            $table->string('descripcion')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidad_espacios');
    }
};
