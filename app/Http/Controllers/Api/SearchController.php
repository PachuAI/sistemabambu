<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function clientes(Request $request)
    {
        $query = $request->get('q', '');
        
        if (empty($query)) {
            return response()->json([]);
        }

        $clientes = Cliente::search($query)
            ->take(10)
            ->get()
            ->map(function ($cliente) {
                return [
                    'id' => $cliente->id,
                    'nombre' => $cliente->nombre,
                    'direccion' => $cliente->direccion,
                    'telefono' => $cliente->telefono,
                    'label' => "{$cliente->nombre} - {$cliente->direccion}",
                ];
            });

        return response()->json($clientes);
    }

    public function productos(Request $request)
    {
        $query = $request->get('q', '');
        
        if (empty($query)) {
            return response()->json([]);
        }

        $productos = Producto::search($query)
            ->take(10)
            ->get()
            ->map(function ($producto) {
                return [
                    'id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'sku' => $producto->sku,
                    'precio_base_l1' => $producto->precio_base_l1,
                    'stock_actual' => $producto->stock_actual,
                    'label' => "{$producto->nombre} ({$producto->sku}) - Stock: {$producto->stock_actual}",
                ];
            });

        return response()->json($productos);
    }
}
