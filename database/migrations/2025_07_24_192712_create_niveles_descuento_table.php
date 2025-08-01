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
        Schema::create('niveles_descuento', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 5);
            $table->decimal('monto_min', 12, 2);
            $table->decimal('porcentaje', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('niveles_descuento');
    }
};
