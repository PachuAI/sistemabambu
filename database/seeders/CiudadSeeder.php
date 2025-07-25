<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ciudad;

class CiudadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ciudades = [
            'Buenos Aires',
            'Córdoba', 
            'Rosario',
            'Mendoza',
            'La Plata',
            'San Miguel de Tucumán',
            'Mar del Plata',
            'Salta',
            'Santa Fe',
            'San Juan',
        ];

        foreach ($ciudades as $ciudad) {
            Ciudad::updateOrCreate(['nombre' => $ciudad]);
        }
    }
}
