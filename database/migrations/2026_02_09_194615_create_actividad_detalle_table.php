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
        Schema::create('actividad_detalle', function (Blueprint $table) {
            $table->id('id_actividad_det');
            $table->unsignedBigInteger('id_actividad_cab');
            $table->date('fecha_evento')->nullable();
            $table->time('hora_desde')->nullable();
            $table->time('hora_hasta')->nullable();
            $table->text('observacion')->nullable();

            $table->foreign('id_actividad_cab')
                ->references('id_actividad_cab')
                ->on('actividad_cabecera')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividad_detalle');
    }
};
