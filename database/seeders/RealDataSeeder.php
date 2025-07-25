<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ciudad;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Vehiculo;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\NivelDescuento;
use App\Models\Provincia;
use Illuminate\Support\Facades\DB;

class RealDataSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar datos existentes
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        DB::table('movimiento_stocks')->truncate();
        DB::table('pedido_items')->truncate();
        DB::table('repartos')->truncate();
        DB::table('pedidos')->truncate();
        DB::table('clientes')->truncate();
        DB::table('productos')->truncate();
        DB::table('vehiculos')->truncate();
        DB::table('ciudades')->truncate();
        DB::table('provincias')->truncate();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. PROVINCIAS
        $provincias = [
            ['nombre' => 'Río Negro', 'codigo' => 'RN'],
            ['nombre' => 'Neuquén', 'codigo' => 'NQ']
        ];

        foreach ($provincias as $provincia) {
            Provincia::create($provincia);
        }

        $rioNegro = Provincia::where('nombre', 'Río Negro')->first();
        $neuquen = Provincia::where('nombre', 'Neuquén')->first();

        // 2. CIUDADES DE RÍO NEGRO Y NEUQUÉN (RUTA 22 y zona) con coordenadas reales
        $ciudades = [
            // Río Negro - Ruta 22 Este
            ['nombre' => 'Ingeniero Huergo', 'provincia_id' => $rioNegro->id, 'codigo_postal' => '8334', 'latitud' => -39.0833, 'longitud' => -67.2167],
            ['nombre' => 'General Roca', 'provincia_id' => $rioNegro->id, 'codigo_postal' => '8332', 'latitud' => -39.0333, 'longitud' => -67.5833],
            ['nombre' => 'Cipolletti', 'provincia_id' => $rioNegro->id, 'codigo_postal' => '8324', 'latitud' => -38.9333, 'longitud' => -68.0000],
            ['nombre' => 'Allen', 'provincia_id' => $rioNegro->id, 'codigo_postal' => '8328', 'latitud' => -39.0167, 'longitud' => -67.8167],
            ['nombre' => 'Chichinales', 'provincia_id' => $rioNegro->id, 'codigo_postal' => '8353', 'latitud' => -39.0500, 'longitud' => -67.3833],
            ['nombre' => 'Chimpay', 'provincia_id' => $rioNegro->id, 'codigo_postal' => '8360', 'latitud' => -39.1667, 'longitud' => -66.1500],
            ['nombre' => 'Choele Choel', 'provincia_id' => $rioNegro->id, 'codigo_postal' => '8360', 'latitud' => -39.2833, 'longitud' => -65.6833],
            ['nombre' => 'Villa Regina', 'provincia_id' => $rioNegro->id, 'codigo_postal' => '8336', 'latitud' => -39.1000, 'longitud' => -67.0667],
            ['nombre' => 'Mainqué', 'provincia_id' => $rioNegro->id, 'codigo_postal' => '8335', 'latitud' => -39.0667, 'longitud' => -67.4000],
            ['nombre' => 'Fernández Oro', 'provincia_id' => $rioNegro->id, 'codigo_postal' => '8324', 'latitud' => -38.9500, 'longitud' => -67.9167],
            ['nombre' => 'Cinco Saltos', 'provincia_id' => $rioNegro->id, 'codigo_postal' => '8303', 'latitud' => -38.8833, 'longitud' => -68.1167],
            ['nombre' => 'Catriel', 'provincia_id' => $rioNegro->id, 'codigo_postal' => '8307', 'latitud' => -37.3833, 'longitud' => -67.8000],
            
            // Neuquén - Ruta 22 Oeste
            ['nombre' => 'Neuquén', 'provincia_id' => $neuquen->id, 'codigo_postal' => '8300', 'latitud' => -38.9516, 'longitud' => -68.0591],
            ['nombre' => 'Plottier', 'provincia_id' => $neuquen->id, 'codigo_postal' => '8316', 'latitud' => -38.9833, 'longitud' => -68.2167],
            ['nombre' => 'Centenario', 'provincia_id' => $neuquen->id, 'codigo_postal' => '8309', 'latitud' => -38.8333, 'longitud' => -68.1333],
            ['nombre' => 'Cutral Có', 'provincia_id' => $neuquen->id, 'codigo_postal' => '8322', 'latitud' => -38.9333, 'longitud' => -69.2333],
            ['nombre' => 'Plaza Huincul', 'provincia_id' => $neuquen->id, 'codigo_postal' => '8318', 'latitud' => -38.9500, 'longitud' => -69.2000],
            ['nombre' => 'Añelo', 'provincia_id' => $neuquen->id, 'codigo_postal' => '8313', 'latitud' => -38.3667, 'longitud' => -68.7167],
        ];

        foreach ($ciudades as $ciudad) {
            Ciudad::create($ciudad);
        }

        // 3. PRODUCTOS QUÍMICOS DE LIMPIEZA (10 productos - Bidones 5L)
        $productosQuimicos = [
            [
                'nombre' => 'Detergente Líquido Industrial BAMBU',
                'sku' => 'BAMBU-DET-5L',
                'precio_base_l1' => 4500.00,
                'stock_actual' => 150,
                'marca_producto' => 'bambu',
                'es_combo' => false,
                'peso_kg' => 5.2,
                'descripcion' => 'Detergente concentrado para limpieza industrial. Bidón 5 litros.'
            ],
            [
                'nombre' => 'Desengrasante Multiuso BAMBU',
                'sku' => 'BAMBU-DES-5L',
                'precio_base_l1' => 3800.00,
                'stock_actual' => 120,
                'marca_producto' => 'bambu',
                'es_combo' => false,
                'peso_kg' => 5.0,
                'descripcion' => 'Desengrasante concentrado multiuso. Bidón 5 litros.'
            ],
            [
                'nombre' => 'Lavandina Concentrada BAMBU',
                'sku' => 'BAMBU-LAV-5L',
                'precio_base_l1' => 3200.00,
                'stock_actual' => 200,
                'marca_producto' => 'bambu',
                'es_combo' => false,
                'peso_kg' => 5.3,
                'descripcion' => 'Lavandina concentrada al 60%. Bidón 5 litros.'
            ],
            [
                'nombre' => 'Desinfectante Hospitalario BAMBU',
                'sku' => 'BAMBU-DIS-5L',
                'precio_base_l1' => 5200.00,
                'stock_actual' => 80,
                'marca_producto' => 'bambu',
                'es_combo' => false,
                'peso_kg' => 5.1,
                'descripcion' => 'Desinfectante de grado hospitalario. Bidón 5 litros.'
            ],
            [
                'nombre' => 'Limpiador de Pisos BAMBU',
                'sku' => 'BAMBU-PIS-5L',
                'precio_base_l1' => 3600.00,
                'stock_actual' => 160,
                'marca_producto' => 'bambu',
                'es_combo' => false,
                'peso_kg' => 5.0,
                'descripcion' => 'Limpiador concentrado para todo tipo de pisos. Bidón 5 litros.'
            ],
            [
                'nombre' => 'Lavavajillas Industrial BAMBU',
                'sku' => 'BAMBU-VAJ-5L',
                'precio_base_l1' => 4100.00,
                'stock_actual' => 90,
                'marca_producto' => 'bambu',
                'es_combo' => false,
                'peso_kg' => 5.1,
                'descripcion' => 'Lavavajillas concentrado para uso industrial. Bidón 5 litros.'
            ],
            [
                'nombre' => 'Quitasarro BAMBU',
                'sku' => 'BAMBU-SAR-5L',
                'precio_base_l1' => 4800.00,
                'stock_actual' => 70,
                'marca_producto' => 'bambu',
                'es_combo' => false,
                'peso_kg' => 5.2,
                'descripcion' => 'Quitasarro ácido para sanitarios. Bidón 5 litros.'
            ],
            [
                'nombre' => 'Lustramuebles BAMBU',
                'sku' => 'BAMBU-LUS-5L',
                'precio_base_l1' => 4200.00,
                'stock_actual' => 100,
                'marca_producto' => 'bambu',
                'es_combo' => false,
                'peso_kg' => 4.8,
                'descripcion' => 'Lustramuebles con cera natural. Bidón 5 litros.'
            ],
            [
                'nombre' => 'Limpia Vidrios BAMBU',
                'sku' => 'BAMBU-VID-5L',
                'precio_base_l1' => 3400.00,
                'stock_actual' => 130,
                'marca_producto' => 'bambu',
                'es_combo' => false,
                'peso_kg' => 5.0,
                'descripcion' => 'Limpia vidrios sin rayas. Bidón 5 litros.'
            ],
            [
                'nombre' => 'Shampoú para Tapizados BAMBU',
                'sku' => 'BAMBU-TAP-5L',
                'precio_base_l1' => 4600.00,
                'stock_actual' => 60,
                'marca_producto' => 'bambu',
                'es_combo' => false,
                'peso_kg' => 5.0,
                'descripcion' => 'Shampoú especial para tapizados y alfombras. Bidón 5 litros.'
            ]
        ];

        foreach ($productosQuimicos as $producto) {
            Producto::create($producto);
        }

        // 4. ARTÍCULOS DE LIMPIEZA (15 productos)
        $articulosLimpieza = [
            [
                'nombre' => 'Escoba Plástica Reforzada',
                'sku' => 'BAMBU-ESC-001',
                'precio_base_l1' => 2800.00,
                'stock_actual' => 50,
                'marca_producto' => 'bambu',
                'es_combo' => false,
                'peso_kg' => 0.8,
                'descripcion' => 'Escoba con cerdas plásticas reforzadas, mango de 1.20m.'
            ],
            [
                'nombre' => 'Mopa Microfibra Profesional',
                'sku' => 'BAMBU-MOP-001',
                'precio_base_l1' => 3200.00,
                'stock_actual' => 40,
                'marca_producto' => 'bambu',
                'es_combo' => false,
                'peso_kg' => 0.5,
                'descripcion' => 'Mopa de microfibra con sistema de escurrido.'
            ],
            [
                'nombre' => 'Trapo de Piso Rejilla x6',
                'sku' => 'BAMBU-TRA-001',
                'precio_base_l1' => 1800.00,
                'stock_actual' => 80,
                'marca_producto' => 'bambu',
                'es_combo' => false,
                'peso_kg' => 0.3,
                'descripcion' => 'Pack de 6 trapos de piso tipo rejilla, absorventes.'
            ],
            [
                'nombre' => 'Balde Plástico con Escurridor',
                'sku' => 'BAMBU-BAL-001',
                'precio_base_l1' => 4500.00,
                'stock_actual' => 25,
                'marca_producto' => 'bambu',
                'es_combo' => false,
                'peso_kg' => 1.2,
                'descripcion' => 'Balde 20L con sistema de escurrido incorporado.'
            ],
            [
                'nombre' => 'Cepillo Multiuso Duro',
                'sku' => 'BAMBU-CEP-001',
                'precio_base_l1' => 1500.00,
                'stock_actual' => 60,
                'marca_producto' => 'bambu',
                'es_combo' => false,
                'peso_kg' => 0.2,
                'descripcion' => 'Cepillo con cerdas duras para limpieza pesada.'
            ],
            [
                'nombre' => 'Esponja Verde Multiuso x12',
                'sku' => 'BAMBU-ESP-001',
                'precio_base_l1' => 2200.00,
                'stock_actual' => 90,
                'marca_producto' => 'bambu',
                'es_combo' => false,
                'peso_kg' => 0.4,
                'descripcion' => 'Pack de 12 esponjas verdes para limpieza general.'
            ],
            [
                'nombre' => 'Guantes Latex Resistentes',
                'sku' => 'BAMBU-GUA-001',
                'precio_base_l1' => 3800.00,
                'stock_actual' => 70,
                'marca_producto' => 'bambu',
                'es_combo' => false,
                'peso_kg' => 0.3,
                'descripcion' => 'Guantes de latex amarillos, resistentes a químicos.'
            ],
            [
                'nombre' => 'Paño Microfibra x5',
                'sku' => 'BAMBU-PAN-001',
                'precio_base_l1' => 2600.00,
                'stock_actual' => 55,
                'marca_producto' => 'bambu',
                'es_combo' => false,
                'peso_kg' => 0.2,
                'descripcion' => 'Pack de 5 paños de microfibra para superficies delicadas.'
            ],
            [
                'nombre' => 'Secador de Pisos Goma',
                'sku' => 'BAMBU-SEC-001',
                'precio_base_l1' => 3500.00,
                'stock_actual' => 30,
                'marca_producto' => 'bambu',
                'es_combo' => false,
                'peso_kg' => 0.7,
                'descripcion' => 'Secador de pisos con goma de 60cm, mango telescópico.'
            ],
            [
                'nombre' => 'Carro de Limpieza con Ruedas',
                'sku' => 'BAMBU-CAR-001',
                'precio_base_l1' => 8500.00,
                'stock_actual' => 15,
                'marca_producto' => 'bambu',
                'es_combo' => false,
                'peso_kg' => 8.0,
                'descripcion' => 'Carro de limpieza profesional con compartimentos y ruedas.'
            ],
            [
                'nombre' => 'Papel Higiénico Institucional x24',
                'sku' => 'BAMBU-PAP-001',
                'precio_base_l1' => 5200.00,
                'stock_actual' => 45,
                'marca_producto' => 'bambu',
                'es_combo' => false,
                'peso_kg' => 3.5,
                'descripcion' => 'Pack de 24 rollos de papel higiénico institucional.'
            ],
            [
                'nombre' => 'Toalla Papel Intercalada x20',
                'sku' => 'BAMBU-TOA-001',
                'precio_base_l1' => 4800.00,
                'stock_actual' => 35,
                'marca_producto' => 'bambu',
                'es_combo' => false,
                'peso_kg' => 2.8,
                'descripcion' => 'Pack de 20 paquetes de toalla papel intercalada.'
            ],
            [
                'nombre' => 'Bolsas Residuos 80x110 x10',
                'sku' => 'BAMBU-BOL-001',
                'precio_base_l1' => 3600.00,
                'stock_actual' => 65,
                'marca_producto' => 'bambu',
                'es_combo' => false,
                'peso_kg' => 1.5,
                'descripcion' => 'Pack de 10 bolsas de residuo reforzadas 80x110cm.'
            ],
            [
                'nombre' => 'Dispensador Papel Higiénico',
                'sku' => 'BAMBU-DIS-001',
                'precio_base_l1' => 6200.00,
                'stock_actual' => 20,
                'marca_producto' => 'bambu',
                'es_combo' => false,
                'peso_kg' => 2.0,
                'descripcion' => 'Dispensador de papel higiénico institucional blanco.'
            ],
            [
                'nombre' => 'Cesto Residuos con Tapa 40L',
                'sku' => 'BAMBU-CES-001',
                'precio_base_l1' => 5800.00,
                'stock_actual' => 18,
                'marca_producto' => 'bambu',
                'es_combo' => false,
                'peso_kg' => 2.5,
                'descripcion' => 'Cesto de residuos plástico con tapa basculante 40L.'
            ]
        ];

        foreach ($articulosLimpieza as $producto) {
            Producto::create($producto);
        }

        // 5. PRODUCTOS SAPHIRUS - FRAGANCIAS (15 productos)
        $fragancias = [
            [
                'nombre' => 'Fragancia Vainilla Premium 500ml',
                'sku' => 'SAPH-VAI-500',
                'precio_base_l1' => 2200.00,
                'stock_actual' => 45,
                'marca_producto' => 'saphirus',
                'es_combo' => false,
                'peso_kg' => 0.6,
                'descripcion' => 'Fragancia ambiental vainilla premium, frasco 500ml.'
            ],
            [
                'nombre' => 'Fragancia Lavanda Relax 500ml',
                'sku' => 'SAPH-LAV-500',
                'precio_base_l1' => 2200.00,
                'stock_actual' => 50,
                'marca_producto' => 'saphirus',
                'es_combo' => false,
                'peso_kg' => 0.6,
                'descripcion' => 'Fragancia ambiental lavanda relajante, frasco 500ml.'
            ],
            [
                'nombre' => 'Fragancia Cítricos Fresh 500ml',
                'sku' => 'SAPH-CIT-500',
                'precio_base_l1' => 2100.00,
                'stock_actual' => 60,
                'marca_producto' => 'saphirus',
                'es_combo' => false,
                'peso_kg' => 0.6,
                'descripcion' => 'Fragancia ambiental cítricos frescos, frasco 500ml.'
            ],
            [
                'nombre' => 'Fragancia Bosque Verde 500ml',
                'sku' => 'SAPH-BOS-500',
                'precio_base_l1' => 2300.00,
                'stock_actual' => 40,
                'marca_producto' => 'saphirus',
                'es_combo' => false,
                'peso_kg' => 0.6,
                'descripcion' => 'Fragancia ambiental bosque verde, frasco 500ml.'
            ],
            [
                'nombre' => 'Fragancia Océano Azul 500ml',
                'sku' => 'SAPH-OCE-500',
                'precio_base_l1' => 2150.00,
                'stock_actual' => 55,
                'marca_producto' => 'saphirus',
                'es_combo' => false,
                'peso_kg' => 0.6,
                'descripcion' => 'Fragancia ambiental océano azul, frasco 500ml.'
            ],
            [
                'nombre' => 'Fragancia Canela Especias 500ml',
                'sku' => 'SAPH-CAN-500',
                'precio_base_l1' => 2400.00,
                'stock_actual' => 35,
                'marca_producto' => 'saphirus',
                'es_combo' => false,
                'peso_kg' => 0.6,
                'descripcion' => 'Fragancia ambiental canela y especias, frasco 500ml.'
            ],
            [
                'nombre' => 'Fragancia Flores Silvestres 500ml',
                'sku' => 'SAPH-FLO-500',
                'precio_base_l1' => 2250.00,
                'stock_actual' => 48,
                'marca_producto' => 'saphirus',
                'es_combo' => false,
                'peso_kg' => 0.6,
                'descripcion' => 'Fragancia ambiental flores silvestres, frasco 500ml.'
            ],
            [
                'nombre' => 'Fragancia Menta Cool 500ml',
                'sku' => 'SAPH-MEN-500',
                'precio_base_l1' => 2100.00,
                'stock_actual' => 52,
                'marca_producto' => 'saphirus',
                'es_combo' => false,
                'peso_kg' => 0.6,
                'descripcion' => 'Fragancia ambiental menta refrescante, frasco 500ml.'
            ],
            [
                'nombre' => 'Fragancia Coco Tropical 500ml',
                'sku' => 'SAPH-COC-500',
                'precio_base_l1' => 2350.00,
                'stock_actual' => 42,
                'marca_producto' => 'saphirus',
                'es_combo' => false,
                'peso_kg' => 0.6,
                'descripcion' => 'Fragancia ambiental coco tropical, frasco 500ml.'
            ],
            [
                'nombre' => 'Fragancia Rosa Elegante 500ml',
                'sku' => 'SAPH-ROS-500',
                'precio_base_l1' => 2500.00,
                'stock_actual' => 38,
                'marca_producto' => 'saphirus',
                'es_combo' => false,
                'peso_kg' => 0.6,
                'descripcion' => 'Fragancia ambiental rosa elegante, frasco 500ml.'
            ],
            [
                'nombre' => 'Fragancia Manzana Verde 500ml',
                'sku' => 'SAPH-MAN-500',
                'precio_base_l1' => 2200.00,
                'stock_actual' => 46,
                'marca_producto' => 'saphirus',
                'es_combo' => false,
                'peso_kg' => 0.6,
                'descripcion' => 'Fragancia ambiental manzana verde, frasco 500ml.'
            ],
            [
                'nombre' => 'Fragancia Jazmín Noche 500ml',
                'sku' => 'SAPH-JAZ-500',
                'precio_base_l1' => 2450.00,
                'stock_actual' => 41,
                'marca_producto' => 'saphirus',
                'es_combo' => false,
                'peso_kg' => 0.6,
                'descripcion' => 'Fragancia ambiental jazmín nocturno, frasco 500ml.'
            ],
            [
                'nombre' => 'Fragancia Bambú Zen 500ml',
                'sku' => 'SAPH-BAM-500',
                'precio_base_l1' => 2300.00,
                'stock_actual' => 44,
                'marca_producto' => 'saphirus',
                'es_combo' => false,
                'peso_kg' => 0.6,
                'descripcion' => 'Fragancia ambiental bambú zen, frasco 500ml.'
            ],
            [
                'nombre' => 'Fragancia Almendra Dulce 500ml',
                'sku' => 'SAPH-ALM-500',
                'precio_base_l1' => 2350.00,
                'stock_actual' => 39,
                'marca_producto' => 'saphirus',
                'es_combo' => false,
                'peso_kg' => 0.6,
                'descripcion' => 'Fragancia ambiental almendra dulce, frasco 500ml.'
            ],
            [
                'nombre' => 'Fragancia Eucalipto Fresh 500ml',
                'sku' => 'SAPH-EUC-500',
                'precio_base_l1' => 2180.00,
                'stock_actual' => 47,
                'marca_producto' => 'saphirus',
                'es_combo' => false,
                'peso_kg' => 0.6,
                'descripcion' => 'Fragancia ambiental eucalipto fresco, frasco 500ml.'
            ]
        ];

        foreach ($fragancias as $producto) {
            Producto::create($producto);
        }

        $this->command->info('✅ Productos creados: ' . Producto::count());

        // 6. CLIENTES DISTRIBUIDOS EN LA ZONA (40 clientes) - Nombres realistas
        $clientesData = [
            // General Roca - 8 clientes
            ['nombre' => 'María Elena González', 'ciudad' => 'General Roca', 'direccion' => 'Belgrano 1250, General Roca', 'email' => 'maria.gonzalez@email.com', 'telefono' => '2984-123456'],
            ['nombre' => 'Roberto Silva', 'ciudad' => 'General Roca', 'direccion' => 'San Martín 890, General Roca', 'email' => 'roberto.silva@email.com', 'telefono' => '2984-234567'],
            ['nombre' => 'Ana Pérez', 'ciudad' => 'General Roca', 'direccion' => 'Rivadavia 567, General Roca', 'email' => 'ana.perez@email.com', 'telefono' => '2984-345678'],
            ['nombre' => 'Carlos Mendoza', 'ciudad' => 'General Roca', 'direccion' => 'Mitre 1134, General Roca', 'email' => 'carlos.mendoza@email.com', 'telefono' => '2984-456789'],
            ['nombre' => 'Luis Martínez', 'ciudad' => 'General Roca', 'direccion' => 'Moreno 780, General Roca', 'email' => 'luis.martinez@email.com', 'telefono' => '2984-567890'],
            ['nombre' => 'Patricia López', 'ciudad' => 'General Roca', 'direccion' => 'Sarmiento 456, General Roca', 'email' => 'patricia.lopez@email.com', 'telefono' => '2984-678901'],
            ['nombre' => 'Diego Ramírez', 'ciudad' => 'General Roca', 'direccion' => 'Córdoba 234, General Roca', 'email' => 'diego.ramirez@email.com', 'telefono' => '2984-789012'],
            ['nombre' => 'Claudia Torres', 'ciudad' => 'General Roca', 'direccion' => 'Tucumán 1023, General Roca', 'email' => 'claudia.torres@email.com', 'telefono' => '2984-890123'],

            // Neuquén - 10 clientes
            ['nombre' => 'Miguel Fernández', 'ciudad' => 'Neuquén', 'direccion' => 'Av. Argentina 250, Neuquén', 'email' => 'miguel.fernandez@email.com', 'telefono' => '299-4444567'],
            ['nombre' => 'Sandra García', 'ciudad' => 'Neuquén', 'direccion' => 'Buenos Aires 145, Neuquén', 'email' => 'sandra.garcia@email.com', 'telefono' => '299-4490300'],
            ['nombre' => 'Marcos Valdebenito', 'ciudad' => 'Neuquén', 'direccion' => 'San Martín 789, Neuquén', 'email' => 'marcos.valdebenito@email.com', 'telefono' => '299-4456789'],
            ['nombre' => 'Elena Rodríguez', 'ciudad' => 'Neuquén', 'direccion' => 'Independencia 1456, Neuquén', 'email' => 'elena.rodriguez@email.com', 'telefono' => '299-4423456'],
            ['nombre' => 'Juan Carlos Vega', 'ciudad' => 'Neuquén', 'direccion' => 'Perito Moreno 567, Neuquén', 'email' => 'juancarlos.vega@email.com', 'telefono' => '299-4440200'],
            ['nombre' => 'Mónica Herrera', 'ciudad' => 'Neuquén', 'direccion' => 'Leloir 234, Neuquén', 'email' => 'monica.herrera@email.com', 'telefono' => '299-4422800'],
            ['nombre' => 'Silvia Morales', 'ciudad' => 'Neuquén', 'direccion' => 'Córdoba 890, Neuquén', 'email' => 'silvia.morales@email.com', 'telefono' => '299-4445678'],
            ['nombre' => 'José Antonio Ruiz', 'ciudad' => 'Neuquén', 'direccion' => 'Rivadavia 1234, Neuquén', 'email' => 'jose.ruiz@email.com', 'telefono' => '299-4447890'],
            ['nombre' => 'Alejandro Castro', 'ciudad' => 'Neuquén', 'direccion' => 'Mitre 678, Neuquén', 'email' => 'alejandro.castro@email.com', 'telefono' => '299-4449999'],
            ['nombre' => 'Carmen Delgado', 'ciudad' => 'Neuquén', 'direccion' => 'Sarmiento 345, Neuquén', 'email' => 'carmen.delgado@email.com', 'telefono' => '299-4448888'],

            // Cipolletti - 6 clientes
            ['nombre' => 'Pedro Sánchez', 'ciudad' => 'Cipolletti', 'direccion' => 'Pellegrini 456, Cipolletti', 'email' => 'pedro.sanchez@email.com', 'telefono' => '299-4772233'],
            ['nombre' => 'Teresa Jiménez', 'ciudad' => 'Cipolletti', 'direccion' => 'Roca 1123, Cipolletti', 'email' => 'teresa.jimenez@email.com', 'telefono' => '299-4773344'],
            ['nombre' => 'Fernando Gutiérrez', 'ciudad' => 'Cipolletti', 'direccion' => 'San Martín 789, Cipolletti', 'email' => 'fernando.gutierrez@email.com', 'telefono' => '299-4774455'],
            ['nombre' => 'Raquel Domínguez', 'ciudad' => 'Cipolletti', 'direccion' => 'Belgrano 234, Cipolletti', 'email' => 'raquel.dominguez@email.com', 'telefono' => '299-4775566'],
            ['nombre' => 'Martín Cabrera', 'ciudad' => 'Cipolletti', 'direccion' => 'Moreno 567, Cipolletti', 'email' => 'martin.cabrera@email.com', 'telefono' => '299-4776677'],
            ['nombre' => 'Laura Benítez', 'ciudad' => 'Cipolletti', 'direccion' => 'Urquiza 890, Cipolletti', 'email' => 'laura.benitez@email.com', 'telefono' => '299-4777788'],

            // Villa Regina - 4 clientes
            ['nombre' => 'Carmen Ruiz', 'ciudad' => 'Villa Regina', 'direccion' => 'Av. Roca 345, Villa Regina', 'email' => 'carmen.ruiz@email.com', 'telefono' => '2984-456123'],
            ['nombre' => 'Andrés Molina', 'ciudad' => 'Villa Regina', 'direccion' => 'San Martín 567, Villa Regina', 'email' => 'andres.molina@email.com', 'telefono' => '2984-567234'],
            ['nombre' => 'Ricardo Paz', 'ciudad' => 'Villa Regina', 'direccion' => 'Belgrano 123, Villa Regina', 'email' => 'ricardo.paz@email.com', 'telefono' => '2984-678345'],
            ['nombre' => 'Susana Álvarez', 'ciudad' => 'Villa Regina', 'direccion' => 'Mitre 789, Villa Regina', 'email' => 'susana.alvarez@email.com', 'telefono' => '2984-789456'],

            // Allen - 3 clientes
            ['nombre' => 'Julio Vargas', 'ciudad' => 'Allen', 'direccion' => 'Sarmiento 234, Allen', 'email' => 'julio.vargas@email.com', 'telefono' => '2984-421567'],
            ['nombre' => 'Marta Guerrero', 'ciudad' => 'Allen', 'direccion' => 'Rivadavia 456, Allen', 'email' => 'marta.guerrero@email.com', 'telefono' => '2984-432678'],
            ['nombre' => 'Jorge Espinoza', 'ciudad' => 'Allen', 'direccion' => 'San Martín 678, Allen', 'email' => 'jorge.espinoza@email.com', 'telefono' => '2984-443789'],

            // Plottier - 3 clientes
            ['nombre' => 'Isabel Moreno', 'ciudad' => 'Plottier', 'direccion' => 'Roca 123, Plottier', 'email' => 'isabel.moreno@email.com', 'telefono' => '299-4881234'],
            ['nombre' => 'Carlos Luna', 'ciudad' => 'Plottier', 'direccion' => 'Moreno 345, Plottier', 'email' => 'carlos.luna@email.com', 'telefono' => '299-4882345'],
            ['nombre' => 'Cristina Rojas', 'ciudad' => 'Plottier', 'direccion' => 'Belgrano 567, Plottier', 'email' => 'cristina.rojas@email.com', 'telefono' => '299-4883456'],

            // Centenario - 2 clientes
            ['nombre' => 'Raúl Díaz', 'ciudad' => 'Centenario', 'direccion' => 'San Martín 789, Centenario', 'email' => 'raul.diaz@email.com', 'telefono' => '299-4891567'],
            ['nombre' => 'Juan Soto', 'ciudad' => 'Centenario', 'direccion' => 'Mitre 234, Centenario', 'email' => 'juan.soto@email.com', 'telefono' => '299-4892678'],

            // Cinco Saltos - 2 clientes
            ['nombre' => 'Pablo Cura', 'ciudad' => 'Cinco Saltos', 'direccion' => 'Ruta 22 Km 1234, Cinco Saltos', 'email' => 'pablo.cura@email.com', 'telefono' => '299-4987654'],
            ['nombre' => 'María Esther Vargas', 'ciudad' => 'Cinco Saltos', 'direccion' => 'Sarmiento 456, Cinco Saltos', 'email' => 'maria.vargas@email.com', 'telefono' => '299-4987432'],

            // Cutral Có - 2 clientes
            ['nombre' => 'Néstor Ríos', 'ciudad' => 'Cutral Có', 'direccion' => 'Av. del Trabajo 567, Cutral Có', 'email' => 'nestor.rios@email.com', 'telefono' => '299-4965123'],
            ['nombre' => 'Alberto Ramos', 'ciudad' => 'Cutral Có', 'direccion' => 'San Martín 890, Cutral Có', 'email' => 'alberto.ramos@email.com', 'telefono' => '299-4965456']
        ];

        foreach ($clientesData as $clienteData) {
            $ciudad = Ciudad::where('nombre', $clienteData['ciudad'])->first();
            if ($ciudad) {
                Cliente::create([
                    'nombre' => $clienteData['nombre'],
                    'ciudad_id' => $ciudad->id,
                    'email' => $clienteData['email'],
                    'telefono' => $clienteData['telefono'],
                    'direccion' => $clienteData['direccion']
                ]);
            }
        }

        $this->command->info('✅ Clientes creados: ' . Cliente::count());

        // 7. VEHÍCULOS DE REPARTO (4 vehículos variados)
        $vehiculos = [
            [
                'nombre' => 'Furgón Mercedes Sprinter (ABC123)',
                'capacidad_bultos' => 45,
                'activo' => true
            ],
            [
                'nombre' => 'Camioneta Toyota Hilux 4x4 (DEF456)',
                'capacidad_bultos' => 25,
                'activo' => true
            ],
            [
                'nombre' => 'Utilitario Renault Kangoo (GHI789)',
                'capacidad_bultos' => 15,
                'activo' => true
            ],
            [
                'nombre' => 'Camión Iveco Daily (JKL012)',
                'capacidad_bultos' => 60,
                'activo' => true
            ]
        ];

        foreach ($vehiculos as $vehiculo) {
            Vehiculo::create($vehiculo);
        }

        $this->command->info('✅ Vehículos creados: ' . Vehiculo::count());

        // 8. PEDIDOS DE EJEMPLO (15 pedidos distribuidos)
        $clientes = Cliente::all();
        $productos = Producto::all();
        $nivelesDescuento = NivelDescuento::all();

        if ($clientes->count() > 0 && $productos->count() > 0 && $nivelesDescuento->count() > 0) {
            for ($i = 1; $i <= 15; $i++) {
                $cliente = $clientes->random();
                $nivelDescuento = $nivelesDescuento->random();
                
                // Crear pedido simple
                $pedido = Pedido::create([
                    'cliente_id' => $cliente->id,
                    'nivel_descuento_id' => $nivelDescuento->id,
                    'monto_bruto' => 0,
                    'monto_final' => 0,
                    'estado' => 'confirmado'
                ]);

                // Agregar productos aleatorios (2-5 productos por pedido)
                $cantidadProductos = rand(2, 5);
                $productosSeleccionados = $productos->random($cantidadProductos);
                $montoBruto = 0;

                foreach ($productosSeleccionados as $producto) {
                    $cantidad = rand(1, 8);
                    $precioUnitario = $producto->precio_base_l1;
                    $subtotalItem = $precioUnitario * $cantidad;
                    
                    PedidoItem::create([
                        'pedido_id' => $pedido->id,
                        'producto_id' => $producto->id,
                        'cantidad' => $cantidad,
                        'precio_unit_l1' => $precioUnitario,
                        'subtotal' => $subtotalItem
                    ]);

                    $montoBruto += $subtotalItem;

                    // Descontar stock
                    $producto->decrement('stock_actual', $cantidad);
                }

                // Calcular descuento y actualizar totales
                $montoDescuento = $montoBruto * ($nivelDescuento->porcentaje / 100);
                $montoFinal = $montoBruto - $montoDescuento;

                $pedido->update([
                    'monto_bruto' => $montoBruto,
                    'monto_final' => $montoFinal
                ]);
            }

            $this->command->info('✅ Pedidos creados: ' . Pedido::count());
        }

        $this->command->info('🎉 ¡Datos realistas cargados exitosamente!');
        $this->command->info('📊 Resumen:');
        $this->command->info('   • Ciudades: ' . Ciudad::count());
        $this->command->info('   • Productos: ' . Producto::count());
        $this->command->info('   • Clientes: ' . Cliente::count());
        $this->command->info('   • Vehículos: ' . Vehiculo::count());
        $this->command->info('   • Pedidos: ' . Pedido::count());
    }
}