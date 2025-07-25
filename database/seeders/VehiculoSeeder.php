<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vehiculo;

class VehiculoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehiculos = [
            [
                'nombre' => 'Ford Transit 350 - BAMBU 01',
                'patente' => 'AB123CD',
                'capacidad_bultos' => 150,
                'estado' => 'disponible',
                'descripcion' => 'Camioneta grande para rutas largas y pedidos voluminosos'
            ],
            [
                'nombre' => 'Renault Kangoo - BAMBU 02',
                'patente' => 'EF456GH',
                'capacidad_bultos' => 80,
                'estado' => 'disponible',
                'descripcion' => 'Vehículo mediano ideal para entregas urbanas'
            ],
            [
                'nombre' => 'Volkswagen Amarok - BAMBU 03',
                'patente' => 'IJ789KL',
                'capacidad_bultos' => 120,
                'estado' => 'disponible',
                'descripcion' => 'Pickup robusta para terrenos difíciles y cargas pesadas'
            ],
            [
                'nombre' => 'Fiat Fiorino - BAMBU 04',
                'patente' => 'MN012OP',
                'capacidad_bultos' => 50,
                'estado' => 'disponible',
                'descripcion' => 'Vehículo compacto para entregas express y zonas céntricas'
            ]
        ];

        foreach ($vehiculos as $vehiculo) {
            Vehiculo::create($vehiculo);
        }
    }
}
