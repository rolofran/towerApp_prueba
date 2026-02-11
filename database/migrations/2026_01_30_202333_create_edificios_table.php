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
        Schema::create('edificios', function (Blueprint $table) {
            $table->id('cod_edificio');

            $table->unsignedBigInteger('cod_empresa');
            $table->foreign('cod_empresa')
                  ->references('cod_empresa')
                  ->on('empresas')
                  ->onDelete('restrict');

            $table->string('nombre');
            $table->string('ruta_logo')->nullable();
            $table->string('direccion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edificios');
    }
};
