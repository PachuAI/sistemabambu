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
        Schema::create('movimiento_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->foreignId('pedido_id')->nullable()->constrained('pedidos')->onDelete('set null');
            $table->integer('cantidad'); // Positivo = entrada, Negativo = salida
            $table->string('motivo', 40); // 'venta', 'ajuste', 'entrada', etc.
            $table->text('observaciones')->nullable();
            $table->timestamp('created_at');
            $table->index(['producto_id', 'created_at']); // Para consultas rápidas
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimiento_stocks');
    }
};
