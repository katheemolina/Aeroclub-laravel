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
            $table->unsignedBigInteger('id_movimiento');
            $table->unsignedBigInteger('id_movimiento_pago');
            $table->timestamps();
            // $table->foreign('id_movimiento')->references('id_movimiento')->on('movimientos');
            $table->foreign('id_movimiento_pago')->references('id_movimiento')->on('movimientos');
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
