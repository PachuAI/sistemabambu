<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CotizadorAjaxController extends Controller
{
    public function agregarProducto(Request $request): JsonResponse
    {
        try {
            $productoId = $request->input('producto_id');
            $producto = Producto::find($productoId);
            
            if (!$producto) {
                return response()->json([
                    'success' => false,
                    'message' => 'Producto no encontrado'
                ], 404);
            }
            
            if ($producto->stock_actual <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Producto sin stock disponible'
                ], 400);
            }
            
            // Datos del producto para el frontend
            $productoData = [
                'producto_id' => (int)$producto->id,
                'nombre' => $producto->nombre,
                'sku' => $producto->sku,
                'precio_base_l1' => (float)$producto->precio_base_l1,
                'cantidad' => 1,
                'subtotal' => (float)$producto->precio_base_l1,
                'stock_disponible' => (int)$producto->stock_actual,
                'es_combo' => (bool)$producto->es_combo,
                'peso_kg' => (float)($producto->peso_kg ?? 5.0),
                'bultos' => round(($producto->peso_kg ?? 5.0) / 5, 2)
            ];
            
            // Log para debug
            \Log::info("=== AJAX PRODUCTO AGREGADO ===");
            \Log::info("ID: {$producto->id}, Nombre: {$producto->nombre}");
            \Log::info("Data enviada: " . json_encode($productoData));
            
            return response()->json([
                'success' => true,
                'message' => "Producto {$producto->nombre} agregado correctamente",
                'producto' => $productoData
            ]);
            
        } catch (\Exception $e) {
            \Log::error("Error en AJAX agregarProducto: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }
}