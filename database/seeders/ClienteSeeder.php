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
        
        // Clientes realistas de Río Negro y Neuquén para pruebas del cotizador
        $clientes = [
            // Bariloche (Río Negro)
            [
                'nombre' => 'Hotel Cacique Inacayal',
                'direccion' => 'Av. Bustillo 1200, Llao Llao',
                'telefono' => '2944-448-530',
                'ciudad_id' => $ciudades->where('nombre', 'San Carlos de Bariloche')->first()?->id,
            ],
            [
                'nombre' => 'Carnicería La Patagónica',
                'direccion' => 'Mitre 525, Centro Cívico',
                'telefono' => '2944-422-815',
                'ciudad_id' => $ciudades->where('nombre', 'San Carlos de Bariloche')->first()?->id,
            ],
            [
                'nombre' => 'Hostería Las Cartas',
                'direccion' => 'Onelli 1155, Centro',
                'telefono' => '2944-425-674',
                'ciudad_id' => $ciudades->where('nombre', 'San Carlos de Bariloche')->first()?->id,
            ],
            
            // Neuquén Capital
            [
                'nombre' => 'Carrefour Neuquén',
                'direccion' => 'Av. Argentina 2450, Centro',
                'telefono' => '299-442-8800',
                'ciudad_id' => $ciudades->where('nombre', 'Neuquén')->first()?->id,
            ],
            [
                'nombre' => 'Restaurant El Cardón',
                'direccion' => 'Roca 887, Centro Neuquén',
                'telefono' => '299-442-1234',
                'ciudad_id' => $ciudades->where('nombre', 'Neuquén')->first()?->id,
            ],
            [
                'nombre' => 'Hotel Carwash Premium',
                'direccion' => 'Santa Fe 145, Neuquén Capital',
                'telefono' => '299-448-7777',
                'ciudad_id' => $ciudades->where('nombre', 'Neuquén')->first()?->id,
            ],
            
            // Viedma (Río Negro)
            [
                'nombre' => 'Supermercado Carrefour',
                'direccion' => 'Av. Caseros 890, Viedma Centro',
                'telefono' => '2920-422-456',
                'ciudad_id' => $ciudades->where('nombre', 'Viedma')->first()?->id,
            ],
            [
                'nombre' => 'Parrilla El Carbón',
                'direccion' => 'Rivadavia 234, Viedma',
                'telefono' => '2920-425-111',
                'ciudad_id' => $ciudades->where('nombre', 'Viedma')->first()?->id,
            ],
            
            // Villa Carlos Paz (si existe en el seeder)
            [
                'nombre' => 'Villa La Angostura Resort',
                'direccion' => 'Costanera Norte 1500',
                'telefono' => '2944-421-999',
                'ciudad_id' => $ciudades->where('nombre', 'Villa La Angostura')->first()?->id,
            ],
            
            // Zapala (Neuquén)
            [
                'nombre' => 'Carnicería Don Carlos',
                'direccion' => 'Etcheluz 456, Zapala Centro',
                'telefono' => '2942-421-456',
                'ciudad_id' => $ciudades->where('nombre', 'Zapala')->first()?->id ?? $ciudades->where('nombre', 'Neuquén')->first()?->id,
            ],
            
            // Clientes adicionales para mejorar las pruebas
            [
                'nombre' => 'Carmen\'s Café & Bistro',
                'direccion' => 'Belgrano 678, Centro',
                'telefono' => '2944-430-789',
                'ciudad_id' => $ciudades->where('nombre', 'San Carlos de Bariloche')->first()?->id,
            ],
            [
                'nombre' => 'Autolavado Central',
                'direccion' => 'Ruta 40 km 2100',
                'telefono' => '299-445-2222',
                'ciudad_id' => $ciudades->where('nombre', 'Neuquén')->first()?->id,
            ],
        ];

        foreach ($clientes as $cliente) {
            Cliente::create($cliente);
        }
    }
}
