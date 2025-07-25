<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::orderBy('nombre')
            ->paginate(15);
            
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
}
