<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cliente;
use App\Models\Ciudad;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ciudades = Ciudad::all();
        
        $clientes = [
            [
                'nombre' => 'Juan Pérez',
                'direccion' => 'Av. Corrientes 1234, CABA',
                'telefono' => '011-4567-8901',
                'ciudad_id' => $ciudades->where('nombre', 'Buenos Aires')->first()->id,
            ],
            [
                'nombre' => 'María González',
                'direccion' => 'San Martín 567, Centro',
                'telefono' => '0351-123-4567',
                'ciudad_id' => $ciudades->where('nombre', 'Córdoba')->first()->id,
            ],
            [
                'nombre' => 'Carlos López',
                'direccion' => 'Mitre 890, Rosario Centro',
                'telefono' => '0341-987-6543',
                'ciudad_id' => $ciudades->where('nombre', 'Rosario')->first()->id,
            ],
            [
                'nombre' => 'Ana Martín',
                'direccion' => 'Las Heras 234, Mendoza',
                'telefono' => '0261-456-7890',
                'ciudad_id' => $ciudades->where('nombre', 'Mendoza')->first()->id,
            ],
            [
                'nombre' => 'Hotel Plaza',
                'direccion' => 'Plaza Mayor 123, CABA',
                'telefono' => '011-2345-6789',
                'ciudad_id' => $ciudades->where('nombre', 'Buenos Aires')->first()->id,
            ],
        ];

        foreach ($clientes as $cliente) {
            Cliente::create($cliente);
        }
    }
}
