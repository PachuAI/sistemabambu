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
        Schema::table('ciudades', function (Blueprint $table) {
            $table->foreignId('provincia_id')->nullable()->constrained('provincias')->onDelete('set null');
            $table->string('codigo_postal', 10)->nullable();
            $table->decimal('latitud', 10, 8)->nullable(); // Coordenadas GPS
            $table->decimal('longitud', 11, 8)->nullable(); // Coordenadas GPS
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ciudades', function (Blueprint $table) {
            $table->dropForeign(['provincia_id']);
            $table->dropColumn(['provincia_id', 'codigo_postal', 'latitud', 'longitud']);
        });
    }
};
