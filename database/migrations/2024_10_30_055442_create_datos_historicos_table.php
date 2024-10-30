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
        Schema::create('datos_historicos', function (Blueprint $table) {
            $table->id(); // ID autoincrementable
            $table->unsignedBigInteger('id_usuario')->unique(); // ID del usuario (único)
            $table->decimal('cantidad_horas_vuelo', 10, 2); // Cantidad de horas de vuelo
            $table->integer('cantidad_aterrizajes'); // Cantidad de aterrizajes

            $table->timestamps();

            // Foreign key constraint
            $table->foreign('id_usuario')->references('id')->on('usuarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datos_historicos');
    }
};
