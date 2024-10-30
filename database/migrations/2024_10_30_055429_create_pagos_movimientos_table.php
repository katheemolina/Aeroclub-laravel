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
        Schema::create('pagos_movimientos', function (Blueprint $table) {
            $table->id(); // ID autoincrementable
            $table->unsignedBigInteger('id_movimiento'); // ID del movimiento
            $table->unsignedBigInteger('id_movimiento_pago')->nullable(); // ID del movimiento de pago que permite NULL
            
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_movimiento')->references('id')->on('movimientos')->onDelete('cascade');
            $table->foreign('id_movimiento_pago')->references('id')->on('movimientos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos_movimientos');
    }
};
