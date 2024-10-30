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
        Schema::create('tarifas', function (Blueprint $table) {
            $table->id('id_tarifa');
            $table->date('fecha_vigencia');
            $table->enum('tipo_tarifa', ['Vuelo', 'Combustible','Instruccion']);
            $table->decimal('importe_vuelo', 10, 2);
            $table->decimal('importe_combustible', 10, 2);
            $table->decimal('importe_instruccion', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarifas');
    }
};
