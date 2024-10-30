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
        Schema::create('aeronaves', function (Blueprint $table) {
            $table->id();
            $table->string('marca');
            $table->string('modelo');
            $table->string('matricula')->unique();
            $table->integer('potencia');
            $table->string('clase');
            $table->date('fecha_adquisicion');
            $table->decimal('consumo_por_hora', 8, 2);
            $table->enum('estado', ['activo', 'baja']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aeronaves');
    }
};
