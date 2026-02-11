<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('flujo_actividades', function (Blueprint $table) {
            $table->id('id_flujo_actividad');
            $table->unsignedBigInteger('id_actividad_cab');
            $table->unsignedBigInteger('id_estado');
            $table->string('cod_usuario', 20);
            $table->date('fecha_mov')->nullable();
            $table->string('observacion')->nullable();
            $table->string('estado_ant')->nullable();
            $table->string('estado')->nullable();
            $table->timestamps();

            // Claves foráneas
            $table->foreign('id_actividad_cab')
                ->references('id_actividad_cab')
                ->on('actividad_cabecera')
                ->onDelete('cascade');

            $table->foreign('id_estado')
                ->references('id_estado')
                ->on('estados')
                ->onDelete('restrict');

            $table->foreign('cod_usuario')
                ->references('cod_usuario')
                ->on('usuarios')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flujo_actividades');
    }
};
