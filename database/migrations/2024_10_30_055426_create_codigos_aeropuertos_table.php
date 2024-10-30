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
        Schema::create('codigos_aeropuertos', function (Blueprint $table) {
            $table->id(); // ID autoincrementable
            $table->string('codigo')->unique(); // Código del aeropuerto
            $table->string('descripcion'); // Descripción del aeropuerto
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codigos_aeropuertos');
    }
};
