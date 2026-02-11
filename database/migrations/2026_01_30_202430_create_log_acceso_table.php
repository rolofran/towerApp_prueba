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
        Schema::create('log_accesos', function (Blueprint $table) {
            $table->id('id_log');
            $table->string('cod_usuario');
            $table->timestamp('fecha_login');
            $table->timestamp('fecha_logout');
            $table->string('ip');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_accesos');
    }
};
