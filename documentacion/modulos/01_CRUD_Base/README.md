# Módulo 01: CRUD Base
## Sistema Fundamental de Entidades

**Propósito:** Implementación de operaciones CRUD tradicionales para las entidades core del sistema (Clientes, Productos, Ciudades) con integración de búsqueda Scout y SoftDeletes.

**Estado:** ✅ **COMPLETADO** - Funcionando en producción

---

## Objetivos del Módulo

### Funcionales
- **CRUD Completo:** Create, Read, Update, Delete para entidades base
- **Búsqueda Integrada:** Scout search con fallback tradicional
- **Validación Robusta:** Form Requests con reglas de negocio
- **Preservación de Datos:** SoftDeletes para integridad histórica

### No Funcionales  
- **Performance:** <2s para operaciones CRUD
- **Usabilidad:** Interfaz intuitiva con Bootstrap 5
- **Escalabilidad:** Soporte hasta 100K registros por entidad
- **Mantenibilidad:** Código limpio siguiendo convenciones Laravel

---

## Entidades Implementadas

### 1. **Clientes**
**Propósito:** Gestión de la base de clientes comerciales
**Archivos clave:**
- `app/Http/Controllers/ClienteController.php`
- `app/Models/Cliente.php`
- `resources/views/clientes/`

**Campos principales:**
```php
Schema::create('clientes', function (Blueprint $table) {
    $table->id();
    $table->string('nombre');
    $table->text('direccion'); // Campo identificador principal
    $table->string('telefono');
    $table->string('email')->nullable();
    $table->foreignId('ciudad_id')->constrained();
    $table->timestamps();
    $table->softDeletes();
});
```

### 2. **Productos**
**Propósito:** Catálogo unificado de productos BAMBU y SAPHIRUS
**Archivos clave:**
- `app/Http/Controllers/ProductoController.php`
- `app/Models/Producto.php`
- `resources/views/productos/`

**Campos principales:**
```php
Schema::create('productos', function (Blueprint $table) {
    $table->id();
    $table->string('nombre');
    $table->string('sku')->unique();
    $table->decimal('precio_base_l1', 10, 2);
    $table->integer('stock_actual')->default(0);
    $table->text('descripcion')->nullable();
    $table->decimal('peso_kg', 8, 2)->nullable();
    $table->enum('marca_producto', ['BAMBU', 'SAPHIRUS']);
    $table->boolean('es_combo')->default(false);
    $table->timestamps();
    $table->softDeletes();
});
```

### 3. **Ciudades**
**Propósito:** Catálogo geográfico para logística
**Archivos clave:**
- `app/Http/Controllers/CiudadController.php`
- `app/Models/Ciudad.php`
- `resources/views/ciudades/`

**Campos principales:**
```php
Schema::create('ciudades', function (Blueprint $table) {
    $table->id();
    $table->string('nombre');
    $table->string('codigo_postal')->nullable();
    $table->foreignId('provincia_id')->constrained();
    $table->decimal('latitud', 10, 8)->nullable();
    $table->decimal('longitud', 11, 8)->nullable();
    $table->timestamps();
    $table->softDeletes();
});
```

---

## Patrón de Implementación CRUD

### Controller Base Estándar
```php
class ClienteController extends Controller
{
    // Lista paginada con búsqueda
    public function index(Request $request)
    {
        $query = Cliente::with('ciudad');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nombre', 'LIKE', "%{$search}%")
                  ->orWhere('direccion', 'LIKE', "%{$search}%");
        }
        
        $clientes = $query->latest()->paginate(20);
        
        return view('clientes.index', compact('clientes'));
    }
    
    // Formulario de creación
    public function create()
    {
        $ciudades = Ciudad::orderBy('nombre')->get();
        return view('clientes.create', compact('ciudades'));
    }
    
    // Persistencia con validación
    public function store(StoreClienteRequest $request)
    {
        $cliente = Cliente::create($request->validated());
        
        return redirect()->route('clientes.index')
                        ->with('success', 'Cliente creado exitosamente');
    }
    
    // Vista de detalle
    public function show(Cliente $cliente)
    {
        $cliente->load('ciudad', 'pedidos');
        return view('clientes.show', compact('cliente'));
    }
    
    // Formulario de edición
    public function edit(Cliente $cliente)
    {
        $ciudades = Ciudad::orderBy('nombre')->get();
        return view('clientes.edit', compact('cliente', 'ciudades'));
    }
    
    // Actualización con validación
    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        $cliente->update($request->validated());
        
        return redirect()->route('clientes.index')
                        ->with('success', 'Cliente actualizado exitosamente');
    }
    
    // Eliminación suave
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        
        return redirect()->route('clientes.index')
                        ->with('success', 'Cliente eliminado exitosamente');
    }
}
```

### Model Base con Traits Estándar
```php
class Cliente extends Model
{
    use HasFactory, SoftDeletes, Searchable;
    
    protected $fillable = [
        'nombre',
        'direccion', 
        'telefono',
        'email',
        'ciudad_id'
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    
    // Relationships
    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class);
    }
    
    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
    
    // Scout searchable configuration
    public function toSearchableArray()
    {
        return [
            'nombre' => $this->nombre,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
        ];
    }
    
    // Scopes útiles
    public function scopeConCiudad($query)
    {
        return $query->with('ciudad');
    }
    
    public function scopeBuscar($query, $termino)
    {
        return $query->where('nombre', 'LIKE', "%{$termino}%")
                    ->orWhere('direccion', 'LIKE', "%{$termino}%");
    }
}
```

---

## Sistema de Validación

### Form Requests Estándar
```php
class StoreClienteRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Manejar con middleware auth
    }
    
    public function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:500',
            'telefono' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'ciudad_id' => 'required|exists:ciudades,id',
        ];
    }
    
    public function messages()
    {
        return [
            'nombre.required' => 'El nombre del cliente es obligatorio',
            'direccion.required' => 'La dirección es obligatoria',
            'telefono.required' => 'El teléfono es obligatorio',
            'ciudad_id.exists' => 'La ciudad seleccionada no es válida',
        ];
    }
}

class UpdateClienteRequest extends StoreClienteRequest
{
    public function rules()
    {
        $rules = parent::rules();
        
        // Validaciones adicionales para update si es necesario
        // Ejemplo: email único excluyendo el registro actual
        $rules['email'] = 'nullable|email|max:255|unique:clientes,email,' . $this->cliente->id;
        
        return $rules;
    }
}
```

### Validaciones Personalizadas
```php
// En el modelo Producto
public static function boot()
{
    parent::boot();
    
    // Validar SKU único incluso con soft deletes
    static::creating(function ($producto) {
        if (static::withTrashed()->where('sku', $producto->sku)->exists()) {
            throw new \InvalidArgumentException('El SKU ya existe en el sistema');
        }
    });
}
```

---

## Integración Scout Search

### Configuración Scout
```php
// config/scout.php
'driver' => 'collection', // Para desarrollo simple

// En producción, usar Algolia o MeiliSearch
'driver' => 'algolia',
```

### Implementación Híbrida de Búsqueda
```php
class SearchController extends Controller
{
    public function clientes(Request $request)
    {
        $termino = $request->get('q', '');
        
        if (empty($termino)) {
            return response()->json(['data' => []]);
        }
        
        // Intento primario: Scout
        $clientes = Cliente::search($termino)->take(10)->get();
        
        // Fallback: Búsqueda tradicional si Scout falla
        if ($clientes->isEmpty()) {
            $clientes = Cliente::where('nombre', 'LIKE', "%{$termino}%")
                              ->orWhere('direccion', 'LIKE', "%{$termino}%")
                              ->limit(10)
                              ->get();
        }
        
        return response()->json([
            'data' => $clientes->map(function ($cliente) {
                return [
                    'id' => $cliente->id,
                    'text' => "{$cliente->nombre} - {$cliente->direccion}",
                    'direccion' => $cliente->direccion,
                    'telefono' => $cliente->telefono,
                    'ciudad' => $cliente->ciudad->nombre ?? 'Sin ciudad'
                ];
            })
        ]);
    }
    
    public function productos(Request $request)
    {
        $termino = $request->get('q', '');
        
        if (empty($termino)) {
            return response()->json(['data' => []]);
        }
        
        // Scout con fallback
        $productos = Producto::search($termino)->take(10)->get();
        
        if ($productos->isEmpty()) {
            $productos = Producto::where('nombre', 'LIKE', "%{$termino}%")
                                ->orWhere('sku', 'LIKE', "%{$termino}%")
                                ->where('stock_actual', '>', 0)
                                ->limit(10)
                                ->get();
        }
        
        return response()->json([
            'data' => $productos->map(function ($producto) {
                return [
                    'id' => $producto->id,
                    'text' => "{$producto->nombre} (SKU: {$producto->sku})",
                    'precio' => $producto->precio_base_l1,
                    'stock' => $producto->stock_actual,
                    'marca' => $producto->marca_producto
                ];
            })
        ]);
    }
}
```

---

## Estructura de Vistas

### Layout Principal
```blade
{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sistema BAMBU') }}</title>
    
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/bambu-theme.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <!-- Navegación principal -->
    </nav>
    
    <div class="container-fluid mt-4">
        @yield('content')
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
```

### Vista Index Estándar
```blade
{{-- resources/views/clientes/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Gestión de Clientes</h2>
            <a href="{{ route('clientes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo Cliente
            </a>
        </div>
        
        <!-- Formulario de búsqueda -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('clientes.index') }}">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="text" 
                                   name="search" 
                                   class="form-control" 
                                   placeholder="Buscar por nombre o dirección..."
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-outline-primary me-2">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                            <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Limpiar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Tabla de resultados -->
        <div class="card">
            <div class="card-body">
                @if($clientes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                    <th>Ciudad</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clientes as $cliente)
                                <tr>
                                    <td>{{ $cliente->nombre }}</td>
                                    <td>{{ $cliente->direccion }}</td>
                                    <td>{{ $cliente->telefono }}</td>
                                    <td>{{ $cliente->ciudad->nombre ?? 'Sin asignar' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('clientes.show', $cliente) }}" 
                                               class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('clientes.edit', $cliente) }}" 
                                               class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" 
                                                  action="{{ route('clientes.destroy', $cliente) }}" 
                                                  style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('¿Está seguro de eliminar este cliente?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Paginación -->
                    <div class="d-flex justify-content-center">
                        {{ $clientes->links() }}
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No se encontraron clientes</h5>
                        <p class="text-muted">
                            @if(request('search'))
                                No hay resultados para "{{ request('search') }}"
                            @else
                                Comience agregando su primer cliente
                            @endif
                        </p>
                        <a href="{{ route('clientes.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Crear Primer Cliente
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
```

---

## Rutas Estándar

```php
// routes/web.php - Patrón resource estándar
Route::middleware(['auth'])->group(function () {
    
    // Rutas CRUD completas
    Route::resource('clientes', ClienteController::class);
    Route::resource('productos', ProductoController::class);  
    Route::resource('ciudades', CiudadController::class);
    
    // APIs de búsqueda
    Route::prefix('api/search')->group(function () {
        Route::get('clientes', [SearchController::class, 'clientes']);
        Route::get('productos', [SearchController::class, 'productos']);
    });
});
```

---

## Testing del Módulo

### Feature Tests
```php
class ClienteCrudTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function puede_listar_clientes()
    {
        $clientes = Cliente::factory(3)->create();
        
        $response = $this->get(route('clientes.index'));
        
        $response->assertOk();
        $response->assertViewIs('clientes.index');
        $response->assertViewHas('clientes');
    }
    
    /** @test */
    public function puede_crear_cliente()
    {
        $ciudad = Ciudad::factory()->create();
        
        $clienteData = [
            'nombre' => 'Cliente de Prueba',
            'direccion' => 'Dirección de Prueba 123',
            'telefono' => '123456789',
            'email' => 'prueba@test.com',
            'ciudad_id' => $ciudad->id
        ];
        
        $response = $this->post(route('clientes.store'), $clienteData);
        
        $response->assertRedirect(route('clientes.index'));
        $this->assertDatabaseHas('clientes', [
            'nombre' => 'Cliente de Prueba',
            'direccion' => 'Dirección de Prueba 123'
        ]);
    }
    
    /** @test */
    public function puede_actualizar_cliente()
    {
        $cliente = Cliente::factory()->create();
        $ciudad = Ciudad::factory()->create();
        
        $updateData = [
            'nombre' => 'Cliente Actualizado',
            'direccion' => $cliente->direccion,
            'telefono' => $cliente->telefono,
            'ciudad_id' => $ciudad->id
        ];
        
        $response = $this->patch(route('clientes.update', $cliente), $updateData);
        
        $response->assertRedirect(route('clientes.index'));
        $this->assertDatabaseHas('clientes', [
            'id' => $cliente->id,
            'nombre' => 'Cliente Actualizado'
        ]);
    }
    
    /** @test */
    public function puede_eliminar_cliente_con_soft_delete()
    {
        $cliente = Cliente::factory()->create();
        
        $response = $this->delete(route('clientes.destroy', $cliente));
        
        $response->assertRedirect(route('clientes.index'));
        $this->assertSoftDeleted('clientes', ['id' => $cliente->id]);
    }
}
```

### Unit Tests para Models
```php
class ClienteModelTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function cliente_pertenece_a_una_ciudad()
    {
        $ciudad = Ciudad::factory()->create();
        $cliente = Cliente::factory()->create(['ciudad_id' => $ciudad->id]);
        
        $this->assertInstanceOf(Ciudad::class, $cliente->ciudad);
        $this->assertEquals($ciudad->id, $cliente->ciudad->id);
    }
    
    /** @test */
    public function cliente_puede_tener_pedidos()
    {
        $cliente = Cliente::factory()->create();
        $pedidos = Pedido::factory(3)->create(['cliente_id' => $cliente->id]);
        
        $this->assertCount(3, $cliente->pedidos);
        $this->assertInstanceOf(Pedido::class, $cliente->pedidos->first());
    }
    
    /** @test */
    public function scope_buscar_funciona_correctamente()
    {
        Cliente::factory()->create(['nombre' => 'Juan Pérez']);
        Cliente::factory()->create(['nombre' => 'María García']);
        Cliente::factory()->create(['direccion' => 'Calle Juan Carlos 123']);
        
        $resultados = Cliente::buscar('Juan')->get();
        
        $this->assertCount(2, $resultados);
    }
}
```

---

## Métricas y KPIs

### Performance
- **Tiempo de carga lista:** <1.5s para 1000 registros
- **Tiempo de búsqueda:** <500ms con índices optimizados
- **Memoria utilizada:** <50MB para operación CRUD completa

### Funcionalidad
- **Cobertura de testing:** >85% para módulo CRUD
- **Validación:** 100% de campos obligatorios validados
- **Integridad:** 0 violaciones de foreign keys

---

## Próximos Pasos

### Mejoras Identificadas
1. **Cache Layer:** Implementar cache para catálogos estáticos
2. **Bulk Operations:** Acciones masivas para administración
3. **Export/Import:** Funcionalidad Excel para migraciones
4. **Advanced Search:** Filtros múltiples y ordenamiento avanzado

### Refactoring Sugerido
1. **Repository Pattern:** Separar lógica de acceso a datos
2. **Service Layer:** Extraer lógica de negocio de controllers
3. **DTO Pattern:** Objetos de transferencia de datos tipados
4. **Event Sourcing:** Para auditoria completa de cambios

---

**Módulo completado y validado** ✅  
**Próximo módulo:** [02_Sistema_Busqueda](../02_Sistema_Busqueda/README.md)