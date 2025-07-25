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
        // Ciudades principales de Río Negro y Neuquén para BAMBU
        $ciudades = [
            // Río Negro
            'San Carlos de Bariloche',
            'Viedma',
            'General Roca',
            'Cipolletti',
            'Villa Regina',
            'Choele Choel',
            'Allen',
            'Catriel',
            'El Bolsón',
            'Cinco Saltos',
            
            // Neuquén
            'Neuquén',
            'Zapala',
            'Cutral Có',
            'Plaza Huincul',
            'Centenario',
            'San Martín de los Andes',
            'Villa La Angostura',
            'Chos Malal',
            'Junín de los Andes',
            'Plottier',
            
            // Otras ciudades para referencia
            'Buenos Aires',
            'Córdoba',
            'Mendoza',
        ];

        foreach ($ciudades as $ciudad) {
            Ciudad::updateOrCreate(['nombre' => $ciudad]);
        }
    }
}
