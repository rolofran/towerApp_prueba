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
        Schema::create('personas', function (Blueprint $table) {
			$table->id(); // PK interna
			$table->string('cod_persona', 20)->unique(); // CI
			$table->string('nombre');
			$table->string('apellido');
			$table->date('fec_nacimiento')->nullable();
			$table->boolean('estado')->default(true);
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
