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
        Schema::create('formularios', function (Blueprint $table) {
            $table->string('cod_form')->primary();
            $table->string('cod_menu');
            $table->string('descripcion');
            $table->boolean('estado')->default(true);
            $table->timestamps();

            $table->foreign('cod_menu')
                  ->references('cod_menu')
                  ->on('menu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formularios');
    }
};
