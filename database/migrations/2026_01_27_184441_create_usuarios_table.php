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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('cod_usuario', 20)->primary();
            $table->string('cod_persona'); // FK a otra tabla de personas
            $table->string('password');
            $table->string('estado', 1)->default('A');
            $table->timestamps();

            $table->foreign('cod_persona')->references('cod_persona')->on('personas');
            // Comentar si no existe tabla personas todavía
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
