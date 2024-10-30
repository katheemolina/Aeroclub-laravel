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
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id('id_movimiento');
            $table->string('tipo');
            $table->unsignedBigInteger('id_ref');
            $table->string('descripcion');
            $table->decimal('importe', 10, 2);
            $table->date('fecha');
            $table->text('observaciones')->nullable();
            $table->unsignedBigInteger('id_usuario');
            $table->timestamps();
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
