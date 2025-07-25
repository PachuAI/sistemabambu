<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NivelDescuento;

class NivelDescuentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $niveles = [
            [
                'nombre' => 'L1',
                'monto_min' => 0.00,
                'porcentaje' => 0.00,
            ],
            [
                'nombre' => 'L2', 
                'monto_min' => 50000.00,
                'porcentaje' => 5.00,
            ],
            [
                'nombre' => 'L3',
                'monto_min' => 100000.00,
                'porcentaje' => 10.00,
            ],
            [
                'nombre' => 'L4',
                'monto_min' => 200000.00,
                'porcentaje' => 15.00,
            ],
        ];

        foreach ($niveles as $nivel) {
            NivelDescuento::updateOrCreate(
                ['nombre' => $nivel['nombre']],
                $nivel
            );
        }
    }
}
