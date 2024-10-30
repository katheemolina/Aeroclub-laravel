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
        Schema::create('recibos', function (Blueprint $table) {
            $table->id('id_recibo');
            $table->string('numero_recibo')->unique();
            $table->string('tipo_recibo');
            $table->decimal('cantidad', 8, 2);
            $table->decimal('importe', 10, 2);
            $table->date('fecha');
            $table->unsignedBigInteger('id_usuario');
            $table->string('instruccion')->nullable();
            $table->text('observaciones')->nullable();
            $table->boolean('estado');
            $table->timestamps();
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recibos');
    }
};
