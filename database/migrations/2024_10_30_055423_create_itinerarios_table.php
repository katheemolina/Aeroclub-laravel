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
        Schema::create('itinerarios', function (Blueprint $table) {
            $table->id('id_itinerario');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_aeronave');
            $table->unsignedBigInteger('id_tarifa');
            $table->unsignedBigInteger('id_tipo_itinerario');
            $table->string('origen');
            $table->time('hora_salida');
            $table->time('hora_llegada');
            $table->string('destino');
            $table->integer('aterrizajes');
            $table->boolean('agregado_por_usuario')->default(0);
            $table->unsignedBigInteger('id_recibo')->nullable();
            $table->timestamps();
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
            $table->foreign('id_aeronave')->references('id_aeronave')->on('aeronaves');
            $table->foreign('id_tarifa')->references('id_tarifa')->on('tarifas');
            $table->foreign('id_tipo_itinerario')->references('id_tipo_itinerario')->on('tipos_itinerarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itinerarios');
    }
};
