<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Producto::create([
        'nombre' => 'Lavandina 5 L',
        'sku' => 'BAM-001',
        'precio_base_l1' => 1200.50,
        'stock_actual' => 100,
        'es_combo' => false,
    ]);

    \App\Models\Producto::create([
        'nombre' => 'Detergente 5 L',
        'sku' => 'BAM-002',
        'precio_base_l1' => 1500.00,
        'stock_actual' => 80,
        'es_combo' => false,
    ]);
    }
}
