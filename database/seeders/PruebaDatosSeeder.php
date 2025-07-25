<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Ciudad;
use App\Models\Provincia;
use App\Models\Vehiculo;
use App\Models\NivelDescuento;

class PruebaDatosSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear provincia si no existe
        $provincia = Provincia::firstOrCreate([
            'nombre' => 'Buenos Aires'
        ]);

        // 2. Crear ciudad si no existe
        $ciudad = Ciudad::firstOrCreate([
            'nombre' => 'La Plata',
            'provincia_id' => $provincia->id
        ]);

        // 3. Crear cliente de prueba
        $cliente = Cliente::create([
            'nombre' => 'Cliente Prueba Testing',
            'direccion' => 'Calle Falsa 123',
            'telefono' => '221-555-0123',
            'email' => 'prueba@testing.com',
            'ciudad_id' => $ciudad->id
        ]);

        // 4. Crear producto de prueba con peso específico
        $producto = Producto::create([
            'nombre' => 'Detergente Prueba 5L',
            'sku' => 'DET-PRUEBA-5L',
            'descripcion' => 'Producto creado para testing del sistema',
            'precio_base_l1' => 2500.00,
            'stock_actual' => 100,
            'peso_kg' => 5.5, // 5.5kg = 1.1 bultos
            'es_combo' => false
        ]);

        // 5. Crear niveles de descuento si no existen
        $nivelesDescuento = [
            ['nombre' => 'L1', 'porcentaje_descuento' => 0],
            ['nombre' => 'L2', 'porcentaje_descuento' => 5],
            ['nombre' => 'L3', 'porcentaje_descuento' => 10],
            ['nombre' => 'L4', 'porcentaje_descuento' => 15]
        ];

        foreach ($nivelesDescuento as $nivel) {
            NivelDescuento::firstOrCreate($nivel);
        }

        // 6. Crear vehículos para el sistema de reparto
        $vehiculos = [
            ['nombre' => 'Camioneta Principal', 'capacidad_bultos' => 150, 'activo' => true],
            ['nombre' => 'Camión Grande', 'capacidad_bultos' => 300, 'activo' => true],
            ['nombre' => 'Furgoneta', 'capacidad_bultos' => 100, 'activo' => true]
        ];

        foreach ($vehiculos as $vehiculo) {
            Vehiculo::firstOrCreate($vehiculo);
        }

        echo "✅ Datos de prueba creados:\n";
        echo "   - Cliente: {$cliente->nombre} (ID: {$cliente->id})\n";
        echo "   - Producto: {$producto->nombre} (ID: {$producto->id})\n";
        echo "   - Stock inicial: {$producto->stock_actual} unidades\n";
        echo "   - Peso: {$producto->peso_kg}kg = {$producto->bultos} bultos\n";
    }
}