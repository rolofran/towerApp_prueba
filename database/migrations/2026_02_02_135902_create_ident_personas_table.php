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
        Schema::create('ident_personas', function (Blueprint $table) {
            $table->id();
            $table->string('cod_persona', 20);
            $table->string('tip_documento', 20);
            $table->string('nro_documento', 20)->unique();
            $table->date('fec_vencimiento')->nullable();
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
        Schema::dropIfExists('ident_personas');
    }
};
