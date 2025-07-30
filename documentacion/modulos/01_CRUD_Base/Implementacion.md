# Implementación Módulo CRUD Base
## Código Específico y Archivos del Sistema

**Módulo:** 01_CRUD_Base  
**Estado:** ✅ Implementado y funcionando  
**Archivos analizados:** Controllers, Models, Views, Migrations

---

## Estructura de Archivos

### Controllers Implementados
```
app/Http/Controllers/
├── ClienteController.php     # CRUD completo clientes
├── ProductoController.php    # CRUD completo productos  
├── CiudadController.php      # CRUD completo ciudades
└── Api/
    └── SearchController.php  # APIs autocomplete
```

### Models con Relationships
```
app/Models/
├── Cliente.php     # Relación con Ciudad, Pedidos
├── Producto.php    # Searchable, SoftDeletes, stock
├── Ciudad.php      # Relación con Provincia, Clientes
└── Provincia.php   # Catálogo de provincias
```

### Views Structure
```
resources/views/
├── layouts/
│   └── app.blade.php        # Layout principal Bootstrap 5
├── clientes/
│   ├── index.blade.php      # Lista paginada con búsqueda
│   ├── create.blade.php     # Formulario creación
│   ├── edit.blade.php       # Formulario edición  
│   └── show.blade.php       # Vista detalle
├── productos/
│   └── [misma estructura]
└── ciudades/
    └── [misma estructura]
```

---

## Implementación Específica por Entidad

### 1. Cliente Controller - Código Real

```php
<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Ciudad;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::with('ciudad')
            ->orderBy('nombre')
            ->paginate(15);
            
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        $ciudades = Ciudad::orderBy('nombre')->get();
        return view('clientes.create', compact('ciudades'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'direccion' => 'required|string|max:255|unique:clientes',
            'telefono' => 'required|string|max:20',
            'ciudad_id' => 'required|exists:ciudades,id',
            'email' => 'nullable|email|max:100',
        ]);

        $cliente = Cliente::create($validated);
        
        return redirect()
            ->route('clientes.show', $cliente)
            ->with('success', 'Cliente creado exitosamente.');
    }

    public function show(Cliente $cliente)
    {
        $cliente->load('ciudad');
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        $ciudades = Ciudad::orderBy('nombre')->get();
        return view('clientes.edit', compact('cliente', 'ciudades'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'direccion' => [
                'required',
                'string',
                'max:255',
                Rule::unique('clientes')->ignore($cliente->id)
            ],
            'telefono' => 'required|string|max:20',
            'ciudad_id' => 'required|exists:ciudades,id',
            'email' => 'nullable|email|max:100',
        ]);

        $cliente->update($validated);
        
        return redirect()
            ->route('clientes.show', $cliente)
            ->with('success', 'Cliente actualizado exitosamente.');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        
        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente eliminado exitosamente.');
    }
}
```

**Puntos clave de implementación:**
- **Eager Loading** con `with('ciudad')` para evitar N+1 queries
- **Validación inline** directa en controller (patrón simple)
- **Rule::unique()->ignore()** para validación de update
- **SoftDeletes** mediante `$cliente->delete()`
- **Paginación** automática con 15 registros por página
- **Redirección con mensajes** de éxito usando sesión flash

### 2. Modelo Cliente - Implementación Real

<function_calls>
<invoke name="Read">
<parameter name="file_path">C:\laragon\www\sistemastockbambu\app\Http\Controllers\ClienteController.php