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
        Schema::create('auditorias', function (Blueprint $table) {
            $table->bigIncrements('id_auditoria');

            $table->string('cod_usuario');
            $table->string('nom_tabla');
            $table->unsignedBigInteger('id_registro');
            $table->string('accion');
            $table->text('detalle')->nullable();

            // Fecha y hora del evento
            $table->timestampTz('fecha_hora')->useCurrent();

            // Control interno Laravel
            $table->timestamps();

            // Índices recomendados
            $table->index('cod_usuario');
            $table->index('nom_tabla');
            $table->index('fecha_hora');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditorias');
    }
};
