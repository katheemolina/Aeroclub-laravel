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
        Schema::create('tarifas_especiales', function (Blueprint $table) {
            $table->id(); // ID autoincrementable
            $table->string('descripcion'); // Descripción de la tarifa especial
            $table->decimal('valor', 10, 2); // Valor de la tarifa especial
            $table->boolean('aplica'); // Indica si aplica o no (booleano)
            $table->unsignedBigInteger('id_usuario'); // ID del usuario que crea la tarifa

            $table->timestamps();

            // Foreign key constraint (puedes modificar el nombre de la columna si es necesario)
            $table->foreign('id_usuario')->references('id')->on('usuarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarifas_especiales');
    }
};
