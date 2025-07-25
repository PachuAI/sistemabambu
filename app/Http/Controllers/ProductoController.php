<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::query();

        // Búsqueda por texto
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                  ->orWhere('sku', 'LIKE', "%{$search}%")
                  ->orWhere('descripcion', 'LIKE', "%{$search}%");
            });
        }

        // Filtro por marca de producto
        if ($request->filled('marca_producto') && $request->get('marca_producto') !== 'todos') {
            $query->where('marca_producto', $request->get('marca_producto'));
        }

        // Filtro por stock bajo (menos de 10 unidades)
        if ($request->filled('stock_bajo') && $request->get('stock_bajo') === '1') {
            $query->where('stock_actual', '<', 10);
        }

        // Ordenamiento
        $orderBy = $request->get('order_by', 'nombre');
        $orderDirection = $request->get('order_direction', 'asc');
        
        $allowedOrderBy = ['nombre', 'sku', 'stock_actual', 'precio_base_l1', 'marca_producto'];
        if (in_array($orderBy, $allowedOrderBy)) {
            $query->orderBy($orderBy, $orderDirection);
        } else {
            $query->orderBy('nombre', 'asc');
        }

        $productos = $query->paginate(20)->appends($request->query());
            
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:120',
            'sku' => 'required|string|max:40|unique:productos',
            'precio_base_l1' => 'required|numeric|min:0',
            'stock_actual' => 'required|integer|min:0',
            'peso_kg' => 'required|numeric|min:0|max:999.999',
            'es_combo' => 'boolean',
            'marca_producto' => 'required|in:bambu,saphirus',
            'descripcion' => 'nullable|string|max:500',
        ]);

        $producto = Producto::create($validated);
        
        return redirect()
            ->route('productos.show', $producto)
            ->with('success', 'Producto creado exitosamente.');
    }

    public function show(Producto $producto)
    {
        return view('productos.show', compact('producto'));
    }

    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:120',
            'sku' => [
                'required',
                'string',
                'max:40',
                Rule::unique('productos')->ignore($producto->id)
            ],
            'precio_base_l1' => 'required|numeric|min:0',
            'stock_actual' => 'required|integer|min:0',
            'peso_kg' => 'required|numeric|min:0|max:999.999',
            'es_combo' => 'boolean',
            'marca_producto' => 'required|in:bambu,saphirus',
            'descripcion' => 'nullable|string|max:500',
        ]);

        // Log de cambio de stock si fue modificado
        $stockAnterior = $producto->stock_actual;
        $stockNuevo = (int) $validated['stock_actual'];
        
        if ($stockAnterior !== $stockNuevo) {
            SystemLog::logStockChange(
                Auth::user()->name,
                $producto->nombre,
                $stockAnterior,
                $stockNuevo,
                'Actualización manual de producto'
            );
        }

        $producto->update($validated);
        
        return redirect()
            ->route('productos.show', $producto)
            ->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        
        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }

    public function deleteMultiple(Request $request)
    {
        $request->validate([
            'productos_ids' => 'required|string',
        ]);

        $productosIds = explode(',', $request->productos_ids);
        $productosIds = array_filter($productosIds, 'is_numeric');

        if (empty($productosIds)) {
            return redirect()
                ->route('productos.index')
                ->with('error', 'No se seleccionaron productos válidos.');
        }

        // Verificar que los productos existen
        $productos = Producto::whereIn('id', $productosIds)->get();
        
        if ($productos->count() !== count($productosIds)) {
            return redirect()
                ->route('productos.index')
                ->with('error', 'Algunos productos seleccionados no existen.');
        }

        // Eliminar productos (soft delete)
        $cantidadEliminada = Producto::whereIn('id', $productosIds)->delete();
        
        return redirect()
            ->route('productos.index')
            ->with('success', "Se eliminaron {$cantidadEliminada} productos exitosamente.");
    }
}
