<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vehiculo;

class VehiculosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehiculos = [
            [
                'nombre' => 'Camioneta Principal',
                'capacidad_bultos' => 150,
                'activo' => true
            ],
            [
                'nombre' => 'Camión Grande',
                'capacidad_bultos' => 300,
                'activo' => true
            ],
            [
                'nombre' => 'Furgoneta',
                'capacidad_bultos' => 100,
                'activo' => true
            ],
            [
                'nombre' => 'Vehículo Compacto',
                'capacidad_bultos' => 50,
                'activo' => true
            ],
            [
                'nombre' => 'Camión Backup',
                'capacidad_bultos' => 200,
                'activo' => false
            ]
        ];

        foreach ($vehiculos as $vehiculo) {
            Vehiculo::create($vehiculo);
        }
    }
}