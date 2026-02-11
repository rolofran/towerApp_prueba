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
        Schema::create('prov_categorias', function (Blueprint $table) {
            $table->id('id_prov_categoria');
            $table->unsignedBigInteger('id_proveedor');
            $table->unsignedBigInteger('id_categoria');
            $table->boolean('estado')->default(true);

            $table->foreign('id_proveedor')
                    ->references('id_proveedor')
                    ->on('proveedores')
                    ->onDelete('cascade');

            $table->foreign('id_categoria')
                    ->references('id_categoria')
                    ->on('categorias')
                    ->onDelete('cascade');
            $table->timestamps();

            $table->unique(['id_proveedor', 'id_categoria']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prov_categorias');
    }
};
