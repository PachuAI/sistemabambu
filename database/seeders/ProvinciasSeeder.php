<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Provincia;

class ProvinciasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provincias = [
            ['nombre' => 'Buenos Aires', 'codigo' => 'BA'],
            ['nombre' => 'Ciudad Autónoma de Buenos Aires', 'codigo' => 'CABA'],
            ['nombre' => 'Catamarca', 'codigo' => 'CA'],
            ['nombre' => 'Chaco', 'codigo' => 'CH'],
            ['nombre' => 'Chubut', 'codigo' => 'CHU'],
            ['nombre' => 'Córdoba', 'codigo' => 'CO'],
            ['nombre' => 'Corrientes', 'codigo' => 'CR'],
            ['nombre' => 'Entre Ríos', 'codigo' => 'ER'],
            ['nombre' => 'Formosa', 'codigo' => 'FO'],
            ['nombre' => 'Jujuy', 'codigo' => 'JU'],
            ['nombre' => 'La Pampa', 'codigo' => 'LP'],
            ['nombre' => 'La Rioja', 'codigo' => 'LR'],
            ['nombre' => 'Mendoza', 'codigo' => 'ME'],
            ['nombre' => 'Misiones', 'codigo' => 'MI'],
            ['nombre' => 'Neuquén', 'codigo' => 'NE'],
            ['nombre' => 'Río Negro', 'codigo' => 'RN'],
            ['nombre' => 'Salta', 'codigo' => 'SA'],
            ['nombre' => 'San Juan', 'codigo' => 'SJ'],
            ['nombre' => 'San Luis', 'codigo' => 'SL'],
            ['nombre' => 'Santa Cruz', 'codigo' => 'SC'],
            ['nombre' => 'Santa Fe', 'codigo' => 'SF'],
            ['nombre' => 'Santiago del Estero', 'codigo' => 'SE'],
            ['nombre' => 'Tierra del Fuego', 'codigo' => 'TF'],
            ['nombre' => 'Tucumán', 'codigo' => 'TU'],
        ];

        foreach ($provincias as $provincia) {
            Provincia::updateOrCreate(
                ['codigo' => $provincia['codigo']],
                $provincia
            );
        }
    }
}
