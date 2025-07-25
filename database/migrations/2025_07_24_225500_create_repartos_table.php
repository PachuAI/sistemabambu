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
        Schema::create('repartos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_reparto');
            $table->foreignId('vehiculo_id')->constrained('vehiculos');
            $table->foreignId('pedido_id')->constrained('pedidos');
            $table->integer('bultos_asignados')->comment('Bultos de este pedido asignados al vehículo');
            $table->integer('orden_entrega')->default(1)->comment('Orden de entrega en la ruta');
            $table->enum('estado', ['planificado', 'en_ruta', 'entregado', 'no_entregado'])->default('planificado');
            $table->text('observaciones')->nullable();
            $table->timestamps();

            // Índices para optimizar consultas
            $table->index(['fecha_reparto', 'vehiculo_id']);
            $table->index(['fecha_reparto', 'estado']);
            
            // Un pedido no puede estar asignado múltiples veces en la misma fecha
            $table->unique(['fecha_reparto', 'pedido_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repartos');
    }
};