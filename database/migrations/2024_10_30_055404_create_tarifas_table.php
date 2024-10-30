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
            $table->id(); // ID autoincrementable
            $table->date('fecha_vigencia'); // Fecha de vigencia de la tarifa
            $table->enum('tipo_tarifa', ['Vuelo', 'Combustible', 'Instrucción']); // Tipo de tarifa
            $table->decimal('importe', 10, 2); // Importe en formato decimal
            $table->decimal('importe_por_instruccion', 10, 2)->nullable(); // Importe por instrucción (puede ser nulo)

            $table->timestamps(); // Campos para las marcas de tiempo
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
