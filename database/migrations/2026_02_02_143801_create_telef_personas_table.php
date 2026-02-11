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
        Schema::create('telef_personas', function (Blueprint $table) {
            $table->id();
            $table->string('cod_persona', 20);
            $table->string('tip_telefono', 20);
            $table->string('num_telefono', 20);
            $table->boolean('por_defecto')->default(false);

            $table->foreign('cod_persona')
                ->references('cod_persona')
                ->on('personas')
                ->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telef_personas');
    }
};
