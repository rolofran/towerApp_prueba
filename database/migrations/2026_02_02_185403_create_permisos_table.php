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
        Schema::create('permisos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('cod_rol');
            $table->string('cod_form');

            $table->boolean('ind_insertar')->default(false);
            $table->boolean('ind_actualizar')->default(false);
            $table->boolean('ind_borrar')->default(false);
            $table->boolean('ind_consultar')->default(false);

            $table->boolean('estado')->default(true);
            $table->timestamps();

            $table->foreign('cod_rol')
                  ->references('cod_rol')
                  ->on('roles');

            $table->foreign('cod_form')
                  ->references('cod_form')
                  ->on('formularios');

            $table->unique(['cod_rol', 'cod_form']);
        }); 
    } 

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permisos');
    }
};
