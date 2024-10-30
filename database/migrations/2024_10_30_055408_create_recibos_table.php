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
            $table->id(); // ID autoincrementable
            $table->string('numero_recibo')->unique(); // Número de recibo definido por el admin
            $table->enum('tipo_recibo', ['vuelo', 'combustible', 'otro']); // Tipo de recibo
            $table->decimal('cantidad', 10, 2); // Cantidad en formato decimal
            $table->decimal('importe', 10, 2); // Importe en formato decimal
            $table->date('fecha'); // Fecha del recibo
            $table->unsignedBigInteger('id_usuario'); // ID del usuario
            $table->boolean('instruccion'); // Instrucción (booleano)
            $table->string('observaciones')->nullable(); // Observaciones
            $table->enum('estado', ['pendiente', 'pagado', 'anulado']); // Estado del recibo
            
            $table->timestamps();

            // Foreign key constraint (modificado para referenciar el ID correcto)
            $table->foreign('id_usuario')->references('id')->on('usuarios')->onDelete('cascade');
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
