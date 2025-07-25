<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\NivelDescuento;
use Carbon\Carbon;

class PedidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        $nivelDescuento = NivelDescuento::first();

        if ($clientes->isEmpty() || $productos->isEmpty()) {
            return; // No crear pedidos si no hay clientes o productos
        }

        // Pedido 1: Carrefour Neuquén - Pedido grande
        $pedido1 = Pedido::create([
            'cliente_id' => $clientes->where('nombre', 'Carrefour Neuquén Centro')->first()->id,
            'nivel_descuento_id' => $nivelDescuento?->id,
            'monto_bruto' => 15750.00,
            'monto_final' => 15750.00,
            'estado' => 'confirmado',
            'created_at' => Carbon::now()->subDays(2)
        ]);

        $items1 = [
            ['producto_id' => $productos->where('sku', 'BAM-001')->first()->id, 'cantidad' => 5, 'precio_unit_l1' => 1250.00, 'subtotal' => 6250.00],
            ['producto_id' => $productos->where('sku', 'BAM-002')->first()->id, 'cantidad' => 3, 'precio_unit_l1' => 1580.00, 'subtotal' => 4740.00],
            ['producto_id' => $productos->where('sku', 'SAP-001')->first()->id, 'cantidad' => 2, 'precio_unit_l1' => 1320.00, 'subtotal' => 2640.00],
            ['producto_id' => $productos->where('sku', 'SAP-003')->first()->id, 'cantidad' => 2, 'precio_unit_l1' => 1180.00, 'subtotal' => 2360.00]
        ];

        foreach ($items1 as $item) {
            $item['pedido_id'] = $pedido1->id;
            PedidoItem::create($item);
        }

        // Pedido 2: Hotel Llao Llao - Pedido mediano
        $pedido2 = Pedido::create([
            'cliente_id' => $clientes->where('nombre', 'Hotel Llao Llao Resort')->first()->id,
            'nivel_descuento_id' => $nivelDescuento?->id,
            'monto_bruto' => 8950.00,
            'monto_final' => 8950.00,
            'estado' => 'confirmado',
            'created_at' => Carbon::now()->subDays(1)
        ]);

        $items2 = [
            ['producto_id' => $productos->where('sku', 'BAM-003')->first()->id, 'cantidad' => 3, 'precio_unit_l1' => 1420.00, 'subtotal' => 4260.00],
            ['producto_id' => $productos->where('sku', 'BAM-008')->first()->id, 'cantidad' => 2, 'precio_unit_l1' => 1480.00, 'subtotal' => 2960.00],
            ['producto_id' => $productos->where('sku', 'SAP-006')->first()->id, 'cantidad' => 1, 'precio_unit_l1' => 1420.00, 'subtotal' => 1420.00],
            ['producto_id' => $productos->where('sku', 'SAP-008')->first()->id, 'cantidad' => 1, 'precio_unit_l1' => 1380.00, 'subtotal' => 1380.00]
        ];

        foreach ($items2 as $item) {
            $item['pedido_id'] = $pedido2->id;
            PedidoItem::create($item);
        }

        // Pedido 3: Supermercado La Anónima - Pedido pequeño
        $pedido3 = Pedido::create([
            'cliente_id' => $clientes->where('nombre', 'Supermercado La Anónima')->first()->id,
            'nivel_descuento_id' => $nivelDescuento?->id,
            'monto_bruto' => 4830.00,
            'monto_final' => 4830.00,
            'estado' => 'confirmado',
            'created_at' => Carbon::now()
        ]);

        $items3 = [
            ['producto_id' => $productos->where('sku', 'BAM-004')->first()->id, 'cantidad' => 2, 'precio_unit_l1' => 1350.00, 'subtotal' => 2700.00],
            ['producto_id' => $productos->where('sku', 'SAP-002')->first()->id, 'cantidad' => 1, 'precio_unit_l1' => 1650.00, 'subtotal' => 1650.00],
            ['producto_id' => $productos->where('sku', 'SAP-008')->first()->id, 'cantidad' => 1, 'precio_unit_l1' => 1380.00, 'subtotal' => 1380.00]
        ];

        foreach ($items3 as $item) {
            $item['pedido_id'] = $pedido3->id;
            PedidoItem::create($item);
        }
    }
}
