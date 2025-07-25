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
        // Ciudades principales de Neuquén y Río Negro con datos completos
        $ciudades = [
            // NEUQUÉN
            [
                'nombre' => 'Neuquén',
                'codigo_postal' => '8300',
                'latitud' => -38.9516,
                'longitud' => -68.0591
            ],
            [
                'nombre' => 'San Martín de los Andes',
                'codigo_postal' => '8370',
                'latitud' => -40.1572,
                'longitud' => -71.3533
            ],
            [
                'nombre' => 'Villa La Angostura',
                'codigo_postal' => '8407',
                'latitud' => -40.7561,
                'longitud' => -71.6446
            ],
            [
                'nombre' => 'Zapala',
                'codigo_postal' => '8340',
                'latitud' => -38.8990,
                'longitud' => -70.0543
            ],
            [
                'nombre' => 'Cutral Có',
                'codigo_postal' => '8322',
                'latitud' => -38.9333,
                'longitud' => -69.2333
            ],
            [
                'nombre' => 'Plaza Huincul',
                'codigo_postal' => '8318',
                'latitud' => -38.9167,
                'longitud' => -69.2000
            ],
            [
                'nombre' => 'Centenario',
                'codigo_postal' => '8309',
                'latitud' => -38.8333,
                'longitud' => -68.1333
            ],
            [
                'nombre' => 'Plottier',
                'codigo_postal' => '8316',
                'latitud' => -38.9667,
                'longitud' => -68.2167
            ],
            
            // RÍO NEGRO
            [
                'nombre' => 'San Carlos de Bariloche',
                'codigo_postal' => '8400',
                'latitud' => -41.1335,
                'longitud' => -71.3103
            ],
            [
                'nombre' => 'General Roca',
                'codigo_postal' => '8332',
                'latitud' => -39.0333,
                'longitud' => -67.5833
            ],
            [
                'nombre' => 'Cipolletti',
                'codigo_postal' => '8324',
                'latitud' => -38.9333,
                'longitud' => -68.0000
            ],
            [
                'nombre' => 'Viedma',
                'codigo_postal' => '8500',
                'latitud' => -40.8135,
                'longitud' => -62.9967
            ],
            [
                'nombre' => 'Villa Regina',
                'codigo_postal' => '8336',
                'latitud' => -39.1000,
                'longitud' => -67.0667
            ],
            [
                'nombre' => 'Allen',
                'codigo_postal' => '8328',
                'latitud' => -38.9833,
                'longitud' => -67.8333
            ],
            [
                'nombre' => 'El Bolsón',
                'codigo_postal' => '8430',
                'latitud' => -41.9667,
                'longitud' => -71.5333
            ]
        ];

        foreach ($ciudades as $ciudadData) {
            Ciudad::updateOrCreate(
                ['nombre' => $ciudadData['nombre']],
                $ciudadData
            );
        }
    }
}
