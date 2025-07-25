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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('nivel_descuento_id')->nullable()->constrained('niveles_descuento')->onDelete('set null');
            $table->decimal('monto_bruto', 12, 2); // Subtotal antes de descuento
            $table->decimal('monto_final', 12, 2); // Total después de descuento
            $table->enum('estado', ['borrador', 'confirmado', 'en_reparto', 'entregado', 'cancelado'])->default('borrador');
            $table->date('fecha_reparto')->nullable(); // Para logística
            $table->timestamps();
            $table->softDeletes(); // Para auditoría
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
