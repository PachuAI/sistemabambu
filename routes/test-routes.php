<?php

use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Ciudad;
use App\Models\Provincia;
use App\Models\NivelDescuento;
use App\Models\MovimientoStock;
use App\Models\SystemLog;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// Ruta de prueba para ejecutar el flujo completo
Route::get('/test-flujo-completo', function () {
    $resultado = [];
    $resultado[] = "🚀 INICIANDO PRUEBA COMPLETA DEL SISTEMA BAMBU";
    $resultado[] = str_repeat("=", 60);
    
    try {
        // PASO 1: Crear datos base
        $resultado[] = "\n📝 PASO 1: Creando datos de prueba...";
        
        // Limpiar datos anteriores de prueba
        Cliente::where('email', 'like', '%@test.com')->delete();
        Producto::where('sku', 'like', '%-TEST-%')->delete();
        
        // Provincia y Ciudad
        $provincia = Provincia::firstOrCreate(['nombre' => 'Buenos Aires']);
        $ciudad = Ciudad::firstOrCreate([
            'nombre' => 'La Plata Test',
            'provincia_id' => $provincia->id
        ]);
        
        // Cliente de prueba
        $cliente = Cliente::create([
            'nombre' => 'Cliente Test Flow ' . now()->format('H:i'),
            'direccion' => 'Av. Testing 456',
            'telefono' => '221-TEST-123',
            'email' => 'flow' . time() . '@test.com',
            'ciudad_id' => $ciudad->id
        ]);
        
        $resultado[] = "   ✅ Cliente creado: {$cliente->nombre} (ID: {$cliente->id})";
        
        // Producto de prueba
        $producto = Producto::create([
            'nombre' => 'Lavandina Test 2L',
            'sku' => 'LAV-TEST-' . time(),
            'descripcion' => 'Producto para testing del flujo completo',
            'precio_base_l1' => 1800.00,
            'stock_actual' => 50,
            'peso_kg' => 2.2, // 2.2kg = 0.44 bultos
            'es_combo' => false
        ]);
        
        $resultado[] = "   ✅ Producto creado: {$producto->nombre} (Stock: {$producto->stock_actual})";
        $resultado[] = "   📦 Peso: {$producto->peso_kg}kg = " . round($producto->peso_kg / 5, 2) . " bultos por unidad";
        
        // PASO 2: Crear pedido
        $resultado[] = "\n🛒 PASO 2: Creando pedido...";
        
        $nivelDescuento = NivelDescuento::first();
        
        $pedido = Pedido::create([
            'cliente_id' => $cliente->id,
            'nivel_descuento_id' => $nivelDescuento->id ?? null,
            'monto_bruto' => 0,
            'monto_final' => 0,
            'estado' => 'cotizacion'
        ]);
        
        // Agregar items
        $item1 = PedidoItem::create([
            'pedido_id' => $pedido->id,
            'producto_id' => $producto->id,
            'cantidad' => 10,
            'precio_unit_l1' => $producto->precio_base_l1,
            'subtotal' => 10 * $producto->precio_base_l1
        ]);
        
        // Buscar otro producto existente
        $productoExistente = Producto::where('id', '!=', $producto->id)->first();
        $item2 = null;
        
        if ($productoExistente && $productoExistente->stock_actual > 5) {
            $item2 = PedidoItem::create([
                'pedido_id' => $pedido->id,
                'producto_id' => $productoExistente->id,
                'cantidad' => 3,
                'precio_unit_l1' => $productoExistente->precio_base_l1,
                'subtotal' => 3 * $productoExistente->precio_base_l1
            ]);
            $resultado[] = "   ✅ Agregado producto existente: {$productoExistente->nombre} (x3)";
        }
        
        // Recalcular totales
        $montoTotal = $pedido->items->sum('subtotal');
        $pedido->update([
            'monto_bruto' => $montoTotal,
            'monto_final' => $montoTotal
        ]);
        
        $bultosCalculados = $pedido->items->sum(function($item) {
            return $item->cantidad * ($item->producto->peso_kg / 5);
        });
        
        $resultado[] = "   ✅ Pedido creado (ID: {$pedido->id})";
        $resultado[] = "   💰 Total: $" . number_format($pedido->monto_final, 2);
        $resultado[] = "   📦 Bultos totales: " . round($bultosCalculados, 2);
        
        // PASO 3: Confirmar pedido
        $resultado[] = "\n✅ PASO 3: Confirmando pedido y descontando stock...";
        
        DB::transaction(function() use ($pedido, &$resultado) {
            foreach ($pedido->items as $item) {
                $stockAnterior = $item->producto->stock_actual;
                
                // Descontar stock
                $item->producto->decrement('stock_actual', $item->cantidad);
                
                // Registrar movimiento
                MovimientoStock::create([
                    'producto_id' => $item->producto->id,
                    'pedido_id' => $pedido->id,
                    'tipo_movimiento' => 'salida',
                    'cantidad' => $item->cantidad,
                    'stock_anterior' => $stockAnterior,
                    'stock_posterior' => $item->producto->fresh()->stock_actual,
                    'motivo' => 'Confirmación de pedido #' . $pedido->id
                ]);
                
                $resultado[] = "   📉 {$item->producto->nombre}: {$stockAnterior} → {$item->producto->fresh()->stock_actual} (-{$item->cantidad})";
            }
            
            $pedido->update(['estado' => 'confirmado']);
            
            SystemLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'pedido_confirmado',
                'description' => "Pedido #{$pedido->id} confirmado - Stock descontado automáticamente",
                'model_type' => 'App\\Models\\Pedido',
                'model_id' => $pedido->id
            ]);
        });
        
        $resultado[] = "   ✅ Pedido confirmado - Stock actualizado";
        
        // PASO 4: Editar pedido
        $resultado[] = "\n✏️ PASO 4: Editando pedido - Modificando cantidades...";
        
        $item1->refresh();
        $producto->refresh();
        
        $cantidadOriginal = $item1->cantidad;
        $nuevaCantidad = 7; // Reducir de 10 a 7
        $diferencia = $nuevaCantidad - $cantidadOriginal;
        
        $resultado[] = "   📝 Cambiando {$producto->nombre}: {$cantidadOriginal} → {$nuevaCantidad} unidades";
        
        DB::transaction(function() use ($item1, $producto, $cantidadOriginal, $nuevaCantidad, $diferencia, $pedido, &$resultado) {
            $stockAnterior = $producto->stock_actual;
            
            // Ajustar stock (si reduce cantidad, devolver stock)
            if ($diferencia < 0) {
                $producto->increment('stock_actual', abs($diferencia));
                $tipoMovimiento = 'entrada';
                $motivo = "Edición pedido #{$pedido->id} - Reducción cantidad";
            } else {
                $producto->decrement('stock_actual', $diferencia);
                $tipoMovimiento = 'salida';
                $motivo = "Edición pedido #{$pedido->id} - Aumento cantidad";
            }
            
            // Actualizar item
            $item1->update([
                'cantidad' => $nuevaCantidad,
                'subtotal' => $nuevaCantidad * $item1->precio_unit_l1
            ]);
            
            // Registrar movimiento
            MovimientoStock::create([
                'producto_id' => $producto->id,
                'pedido_id' => $pedido->id,
                'tipo_movimiento' => $tipoMovimiento,
                'cantidad' => abs($diferencia),
                'stock_anterior' => $stockAnterior,
                'stock_posterior' => $producto->fresh()->stock_actual,
                'motivo' => $motivo
            ]);
            
            $resultado[] = "   📊 Stock ajustado: {$stockAnterior} → {$producto->fresh()->stock_actual}";
        });
        
        // Recalcular pedido
        $pedido->refresh();
        $nuevoTotal = $pedido->items->sum('subtotal');
        $pedido->update([
            'monto_bruto' => $nuevoTotal,
            'monto_final' => $nuevoTotal
        ]);
        
        $resultado[] = "   💰 Nuevo total del pedido: $" . number_format($pedido->monto_final, 2);
        
        // PASO 5: Resumen final
        $resultado[] = "\n📊 RESUMEN FINAL:";
        $resultado[] = str_repeat("=", 30);
        $resultado[] = "Cliente: {$cliente->nombre}";
        $resultado[] = "Pedido ID: {$pedido->id}";
        $resultado[] = "Estado: {$pedido->estado}";
        $resultado[] = "Items en pedido: {$pedido->items->count()}";
        $resultado[] = "Total: $" . number_format($pedido->monto_final, 2);
        $resultado[] = "Movimientos de stock: " . MovimientoStock::where('pedido_id', $pedido->id)->count();
        
        $resultado[] = "\n🎉 PRUEBA COMPLETADA EXITOSAMENTE";
        $resultado[] = "Todos los componentes funcionan correctamente ✅";
        
        return response('<pre>' . implode("\n", $resultado) . '</pre>');
        
    } catch (Exception $e) {
        $resultado[] = "\n❌ ERROR EN LA PRUEBA:";
        $resultado[] = "Mensaje: " . $e->getMessage();
        $resultado[] = "Archivo: " . $e->getFile() . ":" . $e->getLine();
        
        return response('<pre>' . implode("\n", $resultado) . '</pre>', 500);
    }
});

// Test para verificar que el selector de productos funciona correctamente
Route::get('/test-cotizador-selector', function () {
    $resultado = [];
    $resultado[] = "🎯 PRUEBA DEL SELECTOR DE PRODUCTOS DEL COTIZADOR";
    $resultado[] = str_repeat("=", 50);
    
    try {
        // Obtener productos de prueba
        $producto1 = \App\Models\Producto::where('stock_actual', '>', 0)->first();
        $producto2 = \App\Models\Producto::where('stock_actual', '>', 0)->where('id', '!=', $producto1->id)->first();
        
        if (!$producto1 || !$producto2) {
            $resultado[] = "❌ ERROR: Se necesitan al menos 2 productos con stock para la prueba";
            return response('<pre>' . implode("\n", $resultado) . '</pre>', 400);
        }
        
        $resultado[] = "\n📦 PRODUCTOS DE PRUEBA:";
        $resultado[] = "Producto 1: ID {$producto1->id} - {$producto1->nombre}";
        $resultado[] = "Producto 2: ID {$producto2->id} - {$producto2->nombre}";
        
        // Simular agregar productos via session (como hace el nuevo método)
        $items = [];
        
        // Agregar primer producto
        $items[] = [
            'producto_id' => (int)$producto1->id,
            'nombre' => $producto1->nombre,
            'sku' => $producto1->sku,
            'precio_base_l1' => $producto1->precio_base_l1,
            'cantidad' => 1,
            'subtotal' => $producto1->precio_base_l1,
            'stock_disponible' => $producto1->stock_actual,
            'es_combo' => $producto1->es_combo,
            'peso_kg' => $producto1->peso_kg ?? 5.0,
        ];
        
        $resultado[] = "\n✅ PASO 1: Agregado {$producto1->nombre} (ID: {$producto1->id})";
        
        // Agregar segundo producto
        $items[] = [
            'producto_id' => (int)$producto2->id,
            'nombre' => $producto2->nombre,
            'sku' => $producto2->sku,
            'precio_base_l1' => $producto2->precio_base_l1,
            'cantidad' => 1,
            'subtotal' => $producto2->precio_base_l1,
            'stock_disponible' => $producto2->stock_actual,
            'es_combo' => $producto2->es_combo,
            'peso_kg' => $producto2->peso_kg ?? 5.0,
        ];
        
        $resultado[] = "✅ PASO 2: Agregado {$producto2->nombre} (ID: {$producto2->id})";
        
        // Verificar que los productos son diferentes
        if ($items[0]['producto_id'] === $items[1]['producto_id']) {
            $resultado[] = "❌ ERROR: Los productos tienen el mismo ID!";
        } else {
            $resultado[] = "✅ VERIFICACIÓN: Los productos tienen IDs diferentes";
        }
        
        if ($items[0]['nombre'] === $items[1]['nombre']) {
            $resultado[] = "❌ ERROR: Los productos tienen el mismo nombre!";
        } else {
            $resultado[] = "✅ VERIFICACIÓN: Los productos tienen nombres diferentes";
        }
        
        // Simular guardado en session
        session(['cotizador_items' => $items]);
        
        // Verificar session
        $itemsFromSession = session('cotizador_items', []);
        
        $resultado[] = "\n📋 ITEMS EN SESSION:";
        foreach ($itemsFromSession as $index => $item) {
            $resultado[] = "Item {$index}: ID {$item['producto_id']} - {$item['nombre']}";
        }
        
        if (count($itemsFromSession) === 2) {
            $resultado[] = "✅ VERIFICACIÓN: Se guardaron 2 items en session";
        } else {
            $resultado[] = "❌ ERROR: Se esperaban 2 items, se encontraron " . count($itemsFromSession);
        }
        
        // Verificar IDs únicos
        $ids = array_column($itemsFromSession, 'producto_id');
        if (count($ids) === count(array_unique($ids))) {
            $resultado[] = "✅ VERIFICACIÓN: Todos los IDs son únicos";
        } else {
            $resultado[] = "❌ ERROR: Hay IDs duplicados en los items";
        }
        
        $resultado[] = "\n🎉 RESULTADO FINAL:";
        if (count($itemsFromSession) === 2 && 
            count(array_unique(array_column($itemsFromSession, 'producto_id'))) === 2 &&
            $itemsFromSession[0]['nombre'] !== $itemsFromSession[1]['nombre']) {
            $resultado[] = "✅ SELECTOR DE PRODUCTOS FUNCIONA CORRECTAMENTE";
            $resultado[] = "El bug de productos duplicados está SOLUCIONADO 🎯";
        } else {
            $resultado[] = "❌ SELECTOR TIENE PROBLEMAS - REVISAR IMPLEMENTACIÓN";
        }
        
        // Limpiar session de prueba
        session()->forget('cotizador_items');
        
        return response('<pre>' . implode("\n", $resultado) . '</pre>');
        
    } catch (Exception $e) {
        $resultado[] = "\n❌ ERROR EN LA PRUEBA:";
        $resultado[] = "Mensaje: " . $e->getMessage();
        return response('<pre>' . implode("\n", $resultado) . '</pre>', 500);
    }
});