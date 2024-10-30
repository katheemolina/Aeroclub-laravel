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
    Schema::create('usuarios', function (Blueprint $table) {
        $table->id('id');
        $table->string('nombre');
        $table->string('apellido');
        $table->string('email')->unique();
        $table->string('telefono')->nullable();
        $table->unsignedBigInteger('dni')->unique();
        $table->date('fecha_alta');
        $table->date('fecha_baja')->nullable();
        $table->enum('estado', ['Habilitado', 'Deshabilitado']);
        $table->string('localidad')->nullable();
        $table->string('direccion')->nullable();
        $table->date('fecha_vencimiento_cma')->nullable();
        $table->string('foto_perfil')->nullable();
        $table->timestamps();
    });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
