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
        Schema::create('usuario_licencias', function (Blueprint $table) {
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_licencia');
            $table->boolean('estado');
            $table->timestamps();
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
            $table->foreign('id_licencia')->references('id_licencia')->on('licencias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario_licencias');
    }
};
