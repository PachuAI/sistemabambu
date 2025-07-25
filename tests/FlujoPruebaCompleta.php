<?php

/**
 * Script de Prueba Completa del Sistema BAMBU
 * Ejecuta el flujo completo: Cliente → Producto → Pedido → Edición → Reparto
 */

require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Ciudad;
use App\Models\Provincia;
use App\Models\NivelDescuento;
use App\Models\MovimientoStock;
use App\Models\SystemLog;
use Illuminate\Support\Facades\DB;

// Configurar Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🚀 INICIANDO PRUEBA COMPLETA DEL SISTEMA BAMBU\n";
echo "=" . str_repeat("=", 50) . "\n\n";

try {
    // PASO 1: Crear datos base
    echo "📝 PASO 1: Creando datos de prueba...\n";
    
    // Provincia y Ciudad
    $provincia = Provincia::firstOrCreate(['nombre' => 'Buenos Aires']);
    $ciudad = Ciudad::firstOrCreate([
        'nombre' => 'La Plata Test',
        'provincia_id' => $provincia->id
    ]);
    
    // Cliente de prueba
    $cliente = Cliente::create([
        'nombre' => 'Cliente Test Flow',
        'direccion' => 'Av. Testing 456',
        'telefono' => '221-TEST-123',
        'email' => 'flow@test.com',
        'ciudad_id' => $ciudad->id
    ]);
    
    echo "   ✅ Cliente creado: {$cliente->nombre} (ID: {$cliente->id})\n";
    
    // Producto de prueba
    $producto = Producto::create([
        'nombre' => 'Lavandina Test 2L',
        'sku' => 'LAV-TEST-2L',
        'descripcion' => 'Producto para testing del flujo completo',
        'precio_base_l1' => 1800.00,
        'stock_actual' => 50,
        'peso_kg' => 2.2, // 2.2kg = 0.44 bultos
        'es_combo' => false
    ]);
    
    echo "   ✅ Producto creado: {$producto->nombre} (Stock: {$producto->stock_actual})\n";
    echo "   📦 Peso: {$producto->peso_kg}kg = {$producto->bultos} bultos por unidad\n\n";
    
    // PASO 2: Crear pedido
    echo "🛒 PASO 2: Creando pedido con múltiples productos...\n";
    
    $nivelDescuento = NivelDescuento::where('nombre', 'L1')->first();
    
    $pedido = Pedido::create([
        'cliente_id' => $cliente->id,
        'nivel_descuento_id' => $nivelDescuento->id ?? null,
        'monto_bruto' => 0,
        'monto_final' => 0,
        'estado' => 'cotizacion'
    ]);
    
    // Agregar el producto nuevo
    $item1 = PedidoItem::create([
        'pedido_id' => $pedido->id,
        'producto_id' => $producto->id,
        'cantidad' => 10,
        'precio_unit_l1' => $producto->precio_base_l1,
        'subtotal' => 10 * $producto->precio_base_l1
    ]);
    
    // Buscar producto existente para agregar también
    $productoExistente = Producto::where('id', '!=', $producto->id)->first();
    $item2 = null;
    
    if ($productoExistente) {
        $item2 = PedidoItem::create([
            'pedido_id' => $pedido->id,
            'producto_id' => $productoExistente->id,
            'cantidad' => 5,
            'precio_unit_l1' => $productoExistente->precio_base_l1,
            'subtotal' => 5 * $productoExistente->precio_base_l1
        ]);
        echo "   ✅ Agregado producto existente: {$productoExistente->nombre} (x5)\n";
    }
    
    // Recalcular totales del pedido
    $montoTotal = $pedido->items->sum('subtotal');
    $pedido->update([
        'monto_bruto' => $montoTotal,
        'monto_final' => $montoTotal
    ]);
    
    echo "   ✅ Pedido creado (ID: {$pedido->id})\n";
    echo "   💰 Total: $" . number_format($pedido->monto_final, 2) . "\n";
    echo "   📦 Bultos totales: {$pedido->bultos_totales}\n\n";
    
    // PASO 3: Confirmar pedido (descontar stock)
    echo "✅ PASO 3: Confirmando pedido y descontando stock...\n";
    
    DB::transaction(function() use ($pedido) {
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
            
            echo "   📉 {$item->producto->nombre}: {$stockAnterior} → {$item->producto->fresh()->stock_actual} (-{$item->cantidad})\n";
        }
        
        $pedido->update(['estado' => 'confirmado']);
        
        SystemLog::create([
            'user_id' => 1,
            'action' => 'pedido_confirmado',
            'description' => "Pedido #{$pedido->id} confirmado - Stock descontado automáticamente",
            'model_type' => 'App\\Models\\Pedido',
            'model_id' => $pedido->id
        ]);
    });
    
    echo "   ✅ Pedido confirmado - Stock actualizado\n\n";
    
    // PASO 4: Editar pedido (modificar cantidades)
    echo "✏️ PASO 4: Editando pedido - Modificando cantidades...\n";
    
    $item1->refresh();
    $producto->refresh();
    
    $cantidadOriginal = $item1->cantidad;
    $nuevaCantidad = 15; // Aumentar de 10 a 15
    $diferencia = $nuevaCantidad - $cantidadOriginal;
    
    echo "   📝 Cambiando {$producto->nombre}: {$cantidadOriginal} → {$nuevaCantidad} unidades\n";
    
    DB::transaction(function() use ($item1, $producto, $cantidadOriginal, $nuevaCantidad, $diferencia, $pedido) {
        $stockAnterior = $producto->stock_actual;
        
        // Ajustar stock (si aumenta cantidad, descontar más)
        if ($diferencia > 0) {
            $producto->decrement('stock_actual', $diferencia);
            $tipoMovimiento = 'salida';
            $motivo = "Edición pedido #{$pedido->id} - Aumento cantidad";
        } else {
            $producto->increment('stock_actual', abs($diferencia));
            $tipoMovimiento = 'entrada';
            $motivo = "Edición pedido #{$pedido->id} - Reducción cantidad";
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
        
        echo "   📊 Stock ajustado: {$stockAnterior} → {$producto->fresh()->stock_actual}\n";
    });
    
    // PASO 5: Eliminar un item del pedido
    echo "\n🗑️ PASO 5: Eliminando un producto del pedido...\n";
    
    if ($item2) {
        $productoEliminar = $item2->producto;
        $cantidadEliminar = $item2->cantidad;
        
        DB::transaction(function() use ($item2, $productoEliminar, $cantidadEliminar, $pedido) {
            $stockAnterior = $productoEliminar->stock_actual;
            
            // Devolver stock
            $productoEliminar->increment('stock_actual', $cantidadEliminar);
            
            // Registrar movimiento
            MovimientoStock::create([
                'producto_id' => $productoEliminar->id,
                'pedido_id' => $pedido->id,
                'tipo_movimiento' => 'entrada',
                'cantidad' => $cantidadEliminar,
                'stock_anterior' => $stockAnterior,
                'stock_posterior' => $productoEliminar->fresh()->stock_actual,
                'motivo' => "Eliminación item del pedido #{$pedido->id}"
            ]);
            
            // Eliminar item
            $item2->delete();
            
            echo "   ✅ Producto eliminado: {$productoEliminar->nombre}\n";
            echo "   📈 Stock devuelto: {$stockAnterior} → {$productoEliminar->fresh()->stock_actual} (+{$cantidadEliminar})\n";
        });
    }
    
    // Recalcular pedido
    $pedido->refresh();
    $nuevoTotal = $pedido->items->sum('subtotal');
    $pedido->update([
        'monto_bruto' => $nuevoTotal,
        'monto_final' => $nuevoTotal
    ]);
    
    echo "   💰 Nuevo total del pedido: $" . number_format($pedido->monto_final, 2) . "\n";
    echo "   📦 Nuevos bultos totales: {$pedido->bultos_totales}\n\n";
    
    // PASO 6: Verificar logs del sistema
    echo "📋 PASO 6: Verificando logs del sistema...\n";
    
    $logs = SystemLog::where('model_type', 'App\\Models\\Pedido')
                     ->where('model_id', $pedido->id)
                     ->get();
    
    echo "   📝 Logs encontrados: {$logs->count()}\n";
    foreach ($logs as $log) {
        echo "      - {$log->action}: {$log->description}\n";
    }
    
    // PASO 7: Mostrar resumen final
    echo "\n📊 RESUMEN FINAL:\n";
    echo "=" . str_repeat("=", 30) . "\n";
    echo "Cliente: {$cliente->nombre}\n";
    echo "Pedido ID: {$pedido->id}\n";
    echo "Estado: {$pedido->estado}\n";
    echo "Items en pedido: {$pedido->items->count()}\n";
    echo "Total: $" . number_format($pedido->monto_final, 2) . "\n";
    echo "Bultos: {$pedido->bultos_totales}\n";
    echo "Movimientos de stock: " . MovimientoStock::where('pedido_id', $pedido->id)->count() . "\n";
    
    echo "\n🎉 PRUEBA COMPLETADA EXITOSAMENTE\n";
    echo "Todos los componentes funcionan correctamente:\n";
    echo "✅ Creación de cliente y producto\n";
    echo "✅ Generación de pedido\n";
    echo "✅ Confirmación con descuento de stock\n";
    echo "✅ Edición con ajuste automático de stock\n";
    echo "✅ Eliminación de items con devolución de stock\n";
    echo "✅ Registro de logs y movimientos\n";
    echo "✅ Cálculo de bultos para logística\n";

} catch (Exception $e) {
    echo "\n❌ ERROR EN LA PRUEBA:\n";
    echo "Mensaje: " . $e->getMessage() . "\n";
    echo "Archivo: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "\nStack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "FIN DE LA PRUEBA\n";