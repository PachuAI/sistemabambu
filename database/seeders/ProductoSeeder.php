<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // PRODUCTOS BAMBU (fabricación propia)
        $productosBambu = [
            [
                'nombre' => 'Lavandina Concentrada BAMBU 5L',
                'sku' => 'BAM-001',
                'precio_base_l1' => 1250.00,
                'stock_actual' => 150,
                'peso_kg' => 5.2,
                'marca_producto' => 'BAMBU',
                'es_combo' => false,
                'descripcion' => 'Lavandina concentrada para uso comercial e industrial'
            ],
            [
                'nombre' => 'Detergente Líquido BAMBU 5L',
                'sku' => 'BAM-002',
                'precio_base_l1' => 1580.00,
                'stock_actual' => 120,
                'peso_kg' => 5.0,
                'marca_producto' => 'BAMBU',
                'es_combo' => false,
                'descripcion' => 'Detergente líquido biodegradable alta concentración'
            ],
            [
                'nombre' => 'Desinfectante BAMBU 5L',
                'sku' => 'BAM-003',
                'precio_base_l1' => 1420.00,
                'stock_actual' => 80,
                'peso_kg' => 5.1,
                'marca_producto' => 'BAMBU',
                'es_combo' => false,
                'descripcion' => 'Desinfectante multiuso con aroma lavanda'
            ],
            [
                'nombre' => 'Limpiador Multiuso BAMBU 5L',
                'sku' => 'BAM-004',
                'precio_base_l1' => 1350.00,
                'stock_actual' => 100,
                'peso_kg' => 5.0,
                'marca_producto' => 'BAMBU',
                'es_combo' => false,
                'descripcion' => 'Limpiador multiuso para todo tipo de superficies'
            ],
            [
                'nombre' => 'Cera Autobrillante BAMBU 5L',
                'sku' => 'BAM-005',
                'precio_base_l1' => 1890.00,
                'stock_actual' => 60,
                'peso_kg' => 5.3,
                'marca_producto' => 'BAMBU',
                'es_combo' => false,
                'descripcion' => 'Cera autobrillante para pisos cerámicos y porcelanatos'
            ],
            [
                'nombre' => 'Suavizante BAMBU 5L',
                'sku' => 'BAM-006',
                'precio_base_l1' => 1680.00,
                'stock_actual' => 90,
                'peso_kg' => 5.0,
                'marca_producto' => 'BAMBU',
                'es_combo' => false,
                'descripcion' => 'Suavizante de telas aroma floral'
            ],
            [
                'nombre' => 'Desengrasante Industrial BAMBU 5L',
                'sku' => 'BAM-007',
                'precio_base_l1' => 1750.00,
                'stock_actual' => 70,
                'peso_kg' => 5.2,
                'marca_producto' => 'BAMBU',
                'es_combo' => false,
                'descripcion' => 'Desengrasante industrial para cocinas y equipos'
            ],
            [
                'nombre' => 'Jabón Líquido BAMBU 5L',
                'sku' => 'BAM-008',
                'precio_base_l1' => 1480.00,
                'stock_actual' => 110,
                'peso_kg' => 5.0,
                'marca_producto' => 'BAMBU',
                'es_combo' => false,
                'descripcion' => 'Jabón líquido antibacterial para manos'
            ],
            [
                'nombre' => 'Alcohol en Gel BAMBU 5L',
                'sku' => 'BAM-009',
                'precio_base_l1' => 2150.00,
                'stock_actual' => 50,
                'peso_kg' => 4.8,
                'marca_producto' => 'BAMBU',
                'es_combo' => false,
                'descripcion' => 'Alcohol en gel 70% para desinfección de manos'
            ],
            [
                'nombre' => 'Kit Limpieza BAMBU',
                'sku' => 'BAM-KIT-001',
                'precio_base_l1' => 4200.00,
                'stock_actual' => 25,
                'peso_kg' => 15.0,
                'marca_producto' => 'BAMBU',
                'es_combo' => true,
                'descripcion' => 'Kit con lavandina, detergente y desinfectante'
            ]
        ];

        // PRODUCTOS SAPHIRUS (reventa)
        $productosSaphirus = [
            [
                'nombre' => 'Lavandina SAPHIRUS 5L',
                'sku' => 'SAP-001',
                'precio_base_l1' => 1320.00,
                'stock_actual' => 200,
                'peso_kg' => 5.2,
                'marca_producto' => 'SAPHIRUS',
                'es_combo' => false,
                'descripcion' => 'Lavandina clásica SAPHIRUS para uso doméstico'
            ],
            [
                'nombre' => 'Detergente SAPHIRUS 5L',
                'sku' => 'SAP-002',
                'precio_base_l1' => 1650.00,
                'stock_actual' => 180,
                'peso_kg' => 5.0,
                'marca_producto' => 'SAPHIRUS',
                'es_combo' => false,
                'descripcion' => 'Detergente líquido SAPHIRUS alta espuma'
            ],
            [
                'nombre' => 'Limpiador Vidrios SAPHIRUS 5L',
                'sku' => 'SAP-003',
                'precio_base_l1' => 1180.00,
                'stock_actual' => 150,
                'peso_kg' => 5.0,
                'marca_producto' => 'SAPHIRUS',
                'es_combo' => false,
                'descripcion' => 'Limpiador de vidrios sin residuos'
            ],
            [
                'nombre' => 'Desinfectante SAPHIRUS 5L',
                'sku' => 'SAP-004',
                'precio_base_l1' => 1480.00,
                'stock_actual' => 130,
                'peso_kg' => 5.1,
                'marca_producto' => 'SAPHIRUS',
                'es_combo' => false,
                'descripcion' => 'Desinfectante SAPHIRUS eucalipto'
            ],
            [
                'nombre' => 'Cera Líquida SAPHIRUS 5L',
                'sku' => 'SAP-005',
                'precio_base_l1' => 1950.00,
                'stock_actual' => 80,
                'peso_kg' => 5.3,
                'marca_producto' => 'SAPHIRUS',
                'es_combo' => false,
                'descripcion' => 'Cera líquida incolora para pisos'
            ],
            [
                'nombre' => 'Limpiador Baños SAPHIRUS 5L',
                'sku' => 'SAP-006',
                'precio_base_l1' => 1420.00,
                'stock_actual' => 100,
                'peso_kg' => 5.0,
                'marca_producto' => 'SAPHIRUS',
                'es_combo' => false,
                'descripcion' => 'Limpiador especializado para baños'
            ],
            [
                'nombre' => 'Desengrasante SAPHIRUS 5L',
                'sku' => 'SAP-007',
                'precio_base_l1' => 1680.00,
                'stock_actual' => 90,
                'peso_kg' => 5.2,
                'marca_producto' => 'SAPHIRUS',
                'es_combo' => false,
                'descripcion' => 'Desengrasante para cocinas'
            ],
            [
                'nombre' => 'Lavaplatos SAPHIRUS 5L',
                'sku' => 'SAP-008',
                'precio_base_l1' => 1380.00,
                'stock_actual' => 120,
                'peso_kg' => 5.0,
                'marca_producto' => 'SAPHIRUS',
                'es_combo' => false,
                'descripcion' => 'Lavaplatos concentrado limón'
            ],
            [
                'nombre' => 'Suavizante SAPHIRUS 5L',
                'sku' => 'SAP-009',
                'precio_base_l1' => 1580.00,
                'stock_actual' => 110,
                'peso_kg' => 5.0,
                'marca_producto' => 'SAPHIRUS',
                'es_combo' => false,
                'descripcion' => 'Suavizante ropa delicada'
            ],
            [
                'nombre' => 'Pack SAPHIRUS Completo',
                'sku' => 'SAP-PACK-001',
                'precio_base_l1' => 3800.00,
                'stock_actual' => 30,
                'peso_kg' => 20.0,
                'marca_producto' => 'SAPHIRUS',
                'es_combo' => true,
                'descripcion' => 'Pack completo SAPHIRUS 4 productos'
            ]
        ];

        // Crear productos BAMBU
        foreach ($productosBambu as $producto) {
            \App\Models\Producto::create($producto);
        }

        // Crear productos SAPHIRUS
        foreach ($productosSaphirus as $producto) {
            \App\Models\Producto::create($producto);
        }
    }
}
