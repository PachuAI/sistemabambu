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
        Schema::create('system_logs', function (Blueprint $table) {
            $table->id();
            $table->string('usuario', 100); // Usuario que realizó la acción
            $table->text('accion'); // Descripción de la acción realizada
            $table->json('data')->nullable(); // Datos adicionales (opcional para contexto)
            $table->string('modulo', 50)->nullable(); // Módulo del sistema (productos, clientes, etc.)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_logs');
    }
};
