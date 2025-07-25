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
        
        // Clientes comerciales realistas de Neuquén y Río Negro
        $clientes = [
            // NEUQUÉN CAPITAL
            [
                'nombre' => 'Carrefour Neuquén Centro',
                'direccion' => 'Av. Argentina 2450',
                'telefono' => '299-442-8800',
                'email' => 'compras.neuquen@carrefour.com.ar',
                'ciudad_id' => $ciudades->where('nombre', 'Neuquén')->first()?->id,
            ],
            [
                'nombre' => 'Supermercado Vea Portal Patagonia',
                'direccion' => 'Ruta Provincial 7 km 9',
                'telefono' => '299-440-1500',
                'email' => 'gerencia@veapatgonia.com.ar',
                'ciudad_id' => $ciudades->where('nombre', 'Neuquén')->first()?->id,
            ],
            [
                'nombre' => 'Mercado Central Carlos Fuentes',
                'direccion' => 'San Martín 456',
                'telefono' => '299-448-2156',
                'email' => 'mercadocentral@neuquen.gov.ar',
                'ciudad_id' => $ciudades->where('nombre', 'Neuquén')->first()?->id,
            ],
            [
                'nombre' => 'Restaurant Don Mario',
                'direccion' => 'Belgrano 234',
                'telefono' => '299-442-7890',
                'email' => 'donmario@patagonia.com.ar',
                'ciudad_id' => $ciudades->where('nombre', 'Neuquén')->first()?->id,
            ],
            
            // SAN CARLOS DE BARILOCHE
            [
                'nombre' => 'Hotel Llao Llao Resort',
                'direccion' => 'Av. Bustillo 1200',
                'telefono' => '2944-448-530',
                'email' => 'compras@llaollao.com',
                'ciudad_id' => $ciudades->where('nombre', 'San Carlos de Bariloche')->first()?->id,
            ],
            [
                'nombre' => 'Supermercado La Anónima',
                'direccion' => 'Mitre 525',
                'telefono' => '2944-422-815',
                'email' => 'bariloche@lanonima.com.ar',
                'ciudad_id' => $ciudades->where('nombre', 'San Carlos de Bariloche')->first()?->id,
            ],
            [
                'nombre' => 'Chocolatería Havanna',
                'direccion' => 'Bartolomé Mitre 298',
                'telefono' => '2944-425-674',
                'email' => 'havanna.bariloche@havanna.com',
                'ciudad_id' => $ciudades->where('nombre', 'San Carlos de Bariloche')->first()?->id,
            ],
            
            // CIPOLLETTI
            [
                'nombre' => 'Hipermercado Carrefour Cipolletti',
                'direccion' => 'Roca 1145',
                'telefono' => '299-477-2200',
                'email' => 'cipolletti@carrefour.com.ar',
                'ciudad_id' => $ciudades->where('nombre', 'Cipolletti')->first()?->id,
            ],
            [
                'nombre' => 'Mercado Municipal María Elena',
                'direccion' => 'España 567',
                'telefono' => '299-477-1890',
                'email' => 'mercado@cipolletti.gov.ar',
                'ciudad_id' => $ciudades->where('nombre', 'Cipolletti')->first()?->id,
            ],
            
            // GENERAL ROCA
            [
                'nombre' => 'Supermercado Disco Roca',
                'direccion' => 'Av. Roca 1200',
                'telefono' => '298-443-2567',
                'email' => 'roca@disco.com.ar',
                'ciudad_id' => $ciudades->where('nombre', 'General Roca')->first()?->id,
            ],
            [
                'nombre' => 'Restaurant El Parrón',
                'direccion' => 'Tucumán 345',
                'telefono' => '298-443-1789',
                'email' => 'elparron@roca.com.ar',
                'ciudad_id' => $ciudades->where('nombre', 'General Roca')->first()?->id,
            ],
            
            // ZAPALA
            [
                'nombre' => 'Supermercado Norte',
                'direccion' => 'Etcheluz 456',
                'telefono' => '2942-421-456',
                'email' => 'norte@zapala.com.ar',
                'ciudad_id' => $ciudades->where('nombre', 'Zapala')->first()?->id,
            ],
            
            // SAN MARTÍN DE LOS ANDES
            [
                'nombre' => 'Hotel Portal de los Andes',
                'direccion' => 'San Martín 950',
                'telefono' => '2972-427-890',
                'email' => 'portal@sanmartin.com.ar',
                'ciudad_id' => $ciudades->where('nombre', 'San Martín de los Andes')->first()?->id,
            ],
            
            // VILLA LA ANGOSTURA
            [
                'nombre' => 'Hostería Angostura',
                'direccion' => 'Av. Arrayanes 234',
                'telefono' => '2944-494-567',
                'email' => 'hosteria@angostura.com.ar',
                'ciudad_id' => $ciudades->where('nombre', 'Villa La Angostura')->first()?->id,
            ],
            
            // VIEDMA
            [
                'nombre' => 'Supermercado Coto Viedma',
                'direccion' => 'Av. Caseros 890',
                'telefono' => '2920-422-456',
                'email' => 'viedma@coto.com.ar',
                'ciudad_id' => $ciudades->where('nombre', 'Viedma')->first()?->id,
            ]
        ];

        foreach ($clientes as $cliente) {
            Cliente::create($cliente);
        }
    }
}
