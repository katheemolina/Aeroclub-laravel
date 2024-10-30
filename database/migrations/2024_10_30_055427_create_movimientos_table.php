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
            $table->id(); // ID autoincrementable
            $table->enum('tipo', ['recibo', 'cuota_social']); // Tipo de movimiento
            $table->unsignedBigInteger('id_ref'); // ID de referencia
            $table->string('descripcion'); // Descripción del movimiento
            $table->decimal('importe', 10, 2); // Importe del movimiento
            $table->date('fecha'); // Fecha del movimiento
            $table->string('observaciones')->nullable(); // Observaciones (opcional)
            $table->unsignedBigInteger('id_usuario'); // ID del usuario que realiza el movimiento
            
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
        Schema::dropIfExists('movimientos');
    }
};
