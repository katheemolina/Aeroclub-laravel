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
            $table->id(); // ID autoincrementable
            $table->unsignedBigInteger('id_usuario'); // ID del usuario
            $table->unsignedBigInteger('id_aeronave'); // ID de la aeronave
            $table->unsignedBigInteger('id_tarifa'); // ID de la tarifa
            $table->unsignedBigInteger('id_tipo_itinerario'); // ID del tipo de itinerario
            $table->string('origen'); // Origen del vuelo
            $table->time('hora_salida'); // Hora de salida
            $table->time('hora_llegada'); // Hora de llegada
            $table->string('destino'); // Destino del vuelo
            $table->integer('aterrizajes'); // Número de aterrizajes
            $table->boolean('agregado_por_usuario'); // Agregado por usuario (0, 1)
            $table->unsignedBigInteger('id_recibo')->nullable(); // ID del recibo (puede ser nulo)
            
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_usuario')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('id_aeronave')->references('id')->on('aeronaves')->onDelete('cascade');
            $table->foreign('id_tarifa')->references('id')->on('tarifas')->onDelete('cascade');
            $table->foreign('id_tipo_itinerario')->references('id')->on('tipos_itinerarios')->onDelete('cascade');
            $table->foreign('id_recibo')->references('id')->on('recibos')->onDelete('set null'); // El recibo se establece en null si se elimina
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
