<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Producto;
use App\Models\MovimientoStock;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with(['cliente.ciudad', 'nivelDescuento'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('pedidos.index', compact('pedidos'));
    }

    public function show(Pedido $pedido)
    {
        $pedido->load(['cliente.ciudad', 'nivelDescuento', 'items.producto', 'movimientosStock']);
        return view('pedidos.show', compact('pedido'));
    }

    public function update(Request $request, Pedido $pedido)
    {
        // Solo permitir edición de pedidos confirmados
        if ($pedido->estado !== 'confirmado') {
            return redirect()->back()->with('error', 'Solo se pueden editar pedidos en estado confirmado.');
        }

        try {
            DB::transaction(function () use ($request, $pedido) {
                $cambiosRealizados = [];
                
                // Procesar cada item del pedido
                foreach ($request->input('items', []) as $itemId => $itemData) {
                    $pedidoItem = PedidoItem::find($itemId);
                    if (!$pedidoItem || $pedidoItem->pedido_id !== $pedido->id) {
                        continue;
                    }

                    $producto = $pedidoItem->producto;
                    $cantidadAnterior = $pedidoItem->cantidad;
                    $cantidadNueva = (int) $itemData['cantidad'];

                    if ($cantidadNueva <= 0) {
                        // Eliminar item - devolver stock completo
                        $producto->increment('stock_actual', $cantidadAnterior);
                        
                        // Registrar movimiento de stock
                        MovimientoStock::create([
                            'producto_id' => $producto->id,
                            'pedido_id' => $pedido->id,
                            'cantidad' => $cantidadAnterior,
                            'motivo' => 'devolucion_edicion_pedido',
                            'observaciones' => "Item eliminado del pedido #{$pedido->id} - {$producto->nombre}",
                        ]);

                        $pedidoItem->delete();
                        $cambiosRealizados[] = "Eliminado: {$producto->nombre} (cantidad: {$cantidadAnterior})";
                        
                    } else if ($cantidadAnterior !== $cantidadNueva) {
                        // Modificar cantidad - ajustar stock
                        $diferencia = $cantidadNueva - $cantidadAnterior;
                        
                        // Verificar stock disponible
                        if ($diferencia > 0 && $producto->stock_actual < $diferencia) {
                            throw new \Exception("Stock insuficiente para {$producto->nombre}. Disponible: {$producto->stock_actual}");
                        }

                        // Ajustar stock
                        $producto->decrement('stock_actual', $diferencia);
                        
                        // Actualizar item
                        $pedidoItem->update([
                            'cantidad' => $cantidadNueva,
                            'subtotal' => $cantidadNueva * $pedidoItem->precio_unit_l1,
                        ]);

                        // Registrar movimiento de stock
                        MovimientoStock::create([
                            'producto_id' => $producto->id,
                            'pedido_id' => $pedido->id,
                            'cantidad' => -$diferencia,
                            'motivo' => 'edicion_pedido',
                            'observaciones' => "Ajuste por edición del pedido #{$pedido->id} - {$producto->nombre}: {$cantidadAnterior} → {$cantidadNueva}",
                        ]);

                        $cambiosRealizados[] = "Modificado: {$producto->nombre} ({$cantidadAnterior} → {$cantidadNueva})";
                    }
                }

                // Recalcular totales del pedido
                $pedido->load('items.producto', 'nivelDescuento');
                $montoBruto = $pedido->items->sum('subtotal');
                
                // Recalcular descuento si es necesario
                // (En este caso mantenemos el mismo nivel de descuento)
                $montoFinal = $montoBruto;
                if ($pedido->nivelDescuento) {
                    $montoParaDescuento = $pedido->items->filter(function($item) {
                        return !$item->producto->es_combo;
                    })->sum('subtotal');
                    
                    $descuento = $montoParaDescuento * ($pedido->nivelDescuento->porcentaje / 100);
                    $montoFinal = $montoBruto - $descuento;
                }

                // Actualizar pedido
                $pedido->update([
                    'monto_bruto' => $montoBruto,
                    'monto_final' => $montoFinal,
                ]);

                // Log del cambio
                if (!empty($cambiosRealizados)) {
                    SystemLog::log(
                        Auth::user()->name,
                        "Pedido #{$pedido->id} modificado: " . implode(', ', $cambiosRealizados),
                        'pedidos',
                        [
                            'pedido_id' => $pedido->id,
                            'cliente' => $pedido->cliente->nombre,
                            'cambios' => $cambiosRealizados,
                            'monto_anterior' => $request->get('monto_anterior'),
                            'monto_nuevo' => $montoFinal,
                        ]
                    );
                }
            });

            return redirect()->route('pedidos.show', $pedido)
                ->with('success', "Pedido #{$pedido->id} actualizado exitosamente. Stock ajustado automáticamente.");

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar pedido: ' . $e->getMessage());
        }
    }

    public function destroy(Pedido $pedido)
    {
        try {
            DB::transaction(function () use ($pedido) {
                // Devolver stock de todos los items del pedido
                foreach ($pedido->items as $item) {
                    $producto = $item->producto;
                    $producto->increment('stock_actual', $item->cantidad);
                    
                    // Registrar movimiento de stock
                    MovimientoStock::create([
                        'producto_id' => $producto->id,
                        'pedido_id' => $pedido->id,
                        'cantidad' => $item->cantidad,
                        'motivo' => 'cancelacion_pedido',
                        'observaciones' => "Pedido #{$pedido->id} eliminado - devuelto stock de {$producto->nombre}",
                    ]);
                }

                // Log del cambio
                SystemLog::log(
                    Auth::user()->name,
                    "Pedido #{$pedido->id} eliminado",
                    'pedidos',
                    [
                        'pedido_id' => $pedido->id,
                        'cliente' => $pedido->cliente->nombre,
                        'monto_final' => $pedido->monto_final,
                        'items_count' => $pedido->items->count(),
                    ]
                );

                // Eliminar pedido (soft delete)
                $pedido->delete();
            });

            return redirect()->route('pedidos.index')
                ->with('success', "Pedido #{$pedido->id} eliminado exitosamente. Stock devuelto automáticamente.");

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar pedido: ' . $e->getMessage());
        }
    }
}
