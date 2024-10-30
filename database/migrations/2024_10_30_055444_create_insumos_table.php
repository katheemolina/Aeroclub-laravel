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
        Schema::create('insumos', function (Blueprint $table) {
            $table->id(); // ID autoincrementable
            $table->string('descripcion'); // Descripción del insumo
            $table->enum('tipo', ['tipo1', 'tipo2', 'tipo3']); // ver que metemos aca)
            $table->integer('stock'); // Stock disponible
            $table->string('observaciones')->nullable(); // Observaciones (opcional)
            $table->enum('estado', ['activo', 'inactivo']); // Estado del insumo
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insumos');
    }
};
