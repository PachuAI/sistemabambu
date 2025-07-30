# Arquitectura Técnica - Sistema BAMBU
## Decisiones Arquitectónicas y Justificaciones

**Versión:** 1.0  
**Fecha:** 30 de Julio, 2025  
**Stack:** Laravel 12 + PHP 8.2+ + Livewire 3 + Filament v3

---

## 1. Resumen Arquitectónico

### 1.1 Paradigma de Desarrollo
**Arquitectura Híbrida:** Combinación estratégica de patrones tradicionales y modernos
- **Controllers tradicionales + Blade:** Para operaciones CRUD estables
- **Livewire 3:** Para componentes interactivos específicos (cotizador)
- **Filament v3:** Para panel administrativo robusto

### 1.2 Principios Arquitectónicos Adoptados
- **Separación de Responsabilidades:** Cada módulo con propósito específico
- **Modularidad:** Componentes independientes y reutilizables
- **Pragmatismo:** Tecnología apropiada para cada caso de uso
- **Escalabilidad Gradual:** Base sólida para crecimiento futuro

---

## 2. Stack Tecnológico Detallado

### 2.1 Backend Core
```yaml
Framework: Laravel 12
PHP: 8.2+
Base de Datos: SQLite (desarrollo) / MySQL (producción)
ORM: Eloquent con SoftDeletes
Queue: Database driver
Cache: File driver (desarrollo)
```

**Justificación Laravel 12:**
- Framework maduro con ecosistema robusto
- Excelente documentación y comunidad
- Herramientas integradas (Artisan, Scout, etc.)
- Compatibilidad con PHP 8.2+ y features modernas

### 2.2 Frontend Stack
```yaml
CSS Framework: Bootstrap 5 (CDN)
JavaScript: Vanilla JS + Alpine.js (via Livewire)
Build Tool: Vite
Templates: Blade (tradicional) + Livewire Components
Theme: Personalizado lavanda/violeta
```

**Decisión Bootstrap vs Tailwind:**
- Bootstrap elegido por familiaridad del equipo
- Componentes pre-diseñados aceleran desarrollo
- Tema personalizable para branding empresarial
- CDN reduce complejidad de build

### 2.3 Librerías y Paquetes Clave
```yaml
Scout: Laravel Scout (Collection driver)
Permisos: Spatie Laravel Permission
Admin Panel: Filament v3
Authentication: Laravel Breeze
Validation: Form Requests + Custom Rules
Seeding: Factory Pattern + Custom Seeders
```

---

## 3. Arquitectura de Base de Datos

### 3.1 Diseño del Schema
**Enfoque:** Normalizado con desnormalización estratégica para performance

```sql
-- Tablas Maestras (Catálogos)
ciudades: id, nombre, codigo_postal, provincia_id, coordenadas
clientes: id, nombre, direccion, telefono, email, ciudad_id
productos: id, nombre, sku, precio_base_l1, stock_actual, marca

-- Tablas Transaccionales  
pedidos: id, cliente_id, total, nivel_descuento_id, estado, fecha
pedido_items: id, pedido_id, producto_id, cantidad, precio_unitario
movimiento_stocks: id, producto_id, pedido_id, cantidad, motivo

-- Tablas Logísticas
vehiculos: id, nombre, patente, capacidad_bultos, estado
repartos: id, pedido_id, vehiculo_id, fecha_reparto, estado
```

### 3.2 Estrategias de Integridad
```php
// Soft Deletes en todos los modelos críticos
use SoftDeletes;

// Foreign Key Constraints con CASCADE apropiado
$table->foreignId('cliente_id')->constrained()->onDelete('cascade');

// Índices optimizados para consultas frecuentes  
$table->index(['fecha_reparto', 'vehiculo_id']);
$table->index(['sku', 'nombre']); // Para búsquedas de productos
```

### 3.3 Auditoria y Trazabilidad
- **MovimientoStock:** Registro completo de cambios de inventario
- **SystemLog:** Logs de acciones críticas del usuario
- **Timestamps:** created_at/updated_at en todas las tablas
- **SoftDeletes:** Preservación de datos históricos

---

## 4. Arquitectura de Aplicación

### 4.1 Estructura de Directorios
```
app/
├── Http/Controllers/          # Controllers tradicionales
│   ├── Api/                  # APIs para autocomplete
│   └── [Entity]Controller.php # CRUD tradicional
├── Livewire/                 # Componentes interactivos
│   └── Cotizador.php        # Componente principal
├── Models/                   # Eloquent Models
│   ├── Traits/              # Traits reutilizables
│   └── [Entity].php         # Models con relationships
└── Services/                 # Lógica de negocio (futuro)
```

### 4.2 Patrón de Controllers
**Controllers Tradicionales:**
```php
class ClienteController extends Controller
{
    public function index()     // Lista paginada con búsqueda
    public function create()    // Formulario de creación
    public function store()     // Validación + persistencia
    public function show($id)   // Vista detalle
    public function edit($id)   // Formulario edición
    public function update()    // Validación + actualización
    public function destroy()   // Soft delete
}
```

**Justificación:** Patrón familiar, estable, fácil testing, menor complejidad

### 4.3 Componentes Livewire
**Uso Específico:** Solo para interacciones complejas en tiempo real
```php
class Cotizador extends Component
{
    public $cliente = null;           // Cliente seleccionado
    public $productos = [];           // Array de productos
    public $total = 0;               // Total calculado
    public $nivel_descuento = null;  // Descuento aplicable
    
    public function mount() { }       // Inicialización
    public function render() { }      // Vista del componente  
    public function updatedTotal() { } // Recálculo automático
}
```

**Criterios para Livewire vs Controller:**
- **Livewire:** Interacciones en tiempo real, estado complejo, UX rica
- **Controller:** CRUD simple, operaciones atómicas, estabilidad

---

## 5. Arquitectura de Búsqueda

### 5.1 Sistema Híbrido Scout + Fallback
**Implementación Dual:** Scout primario con fallback traditional

```php
// Estrategia de búsqueda híbrida
public function buscarProductos($termino)
{
    // Intento primario: Laravel Scout
    $productos = Producto::search($termino)->get();
    
    // Fallback: Consulta LIKE tradicional
    if ($productos->isEmpty()) {
        $productos = Producto::where('nombre', 'LIKE', "%{$termino}%")
                            ->orWhere('sku', 'LIKE', "%{$termino}%")
                            ->get();
    }
    
    return $productos;
}
```

**Justificación:**
- **Scout:** Performance superior para búsquedas complejas
- **Fallback:** Garantiza funcionamiento sin dependencias externas
- **Flexibilidad:** Migración gradual a motores de búsqueda avanzados

### 5.2 APIs de Autocomplete
**Endpoints optimizados:**
```php
Route::get('/api/search/clientes', [SearchController::class, 'clientes']);
Route::get('/api/search/productos', [SearchController::class, 'productos']);

// Respuesta JSON optimizada
return response()->json([
    'data' => $clientes->map(fn($c) => [
        'id' => $c->id,
        'text' => "{$c->nombre} - {$c->direccion}",
        'direccion' => $c->direccion,
        'telefono' => $c->telefono
    ])
]);
```

---

## 6. Decisiones de Arquitectura Críticas

### 6.1 Livewire vs Controllers: Matriz de Decisión

| Criterio | Livewire | Controller Tradicional |
|----------|----------|----------------------|
| **Complejidad Estado** | Alto ✅ | Bajo ✅ |
| **Interactividad Tiempo Real** | Requerida ✅ | No requerida ✅ |
| **Estabilidad** | Media ⚠️ | Alta ✅ |
| **Curva Aprendizaje** | Alta ⚠️ | Baja ✅ |
| **Testing** | Complejo ⚠️ | Simple ✅ |
| **Performance** | Variable ⚠️ | Predecible ✅ |

**Decisión:** Livewire solo para cotizador, resto controllers tradicionales

### 6.2 Base de Datos: SQLite vs MySQL
**Desarrollo:** SQLite por simplicidad setup
**Producción:** MySQL por robustez y concurrencia

```php
// config/database.php - Configuración dual
'connections' => [
    'sqlite' => [
        'driver' => 'sqlite',
        'database' => database_path('database.sqlite'),
    ],
    'mysql' => [
        'driver' => 'mysql',
        'host' => env('DB_HOST', '127.0.0.1'),
        // ... configuración producción
    ],
]
```

### 6.3 Frontend: SPA vs Server-Side Rendering
**Decisión:** Server-side rendering con Blade + interacciones Livewire

**Justificación:**
- **Time-to-market:** Desarrollo más rápido
- **SEO:** No crítico para aplicación interna
- **Simplicidad:** Menor complejidad arquitectónica
- **Expertise del equipo:** Conocimiento existente Laravel/Blade

---

## 7. Patrones de Diseño Implementados

### 7.1 Repository Pattern (Futuro)
**Estado Actual:** Models directo en Controllers
**Evolución:** Migración gradual a Repository Pattern

```php
// Patrón futuro para escalabilidad
interface ClienteRepositoryInterface
{
    public function find($id);
    public function search($term);
    public function create(array $data);
}

class EloquentClienteRepository implements ClienteRepositoryInterface
{
    // Implementación específica Eloquent
}
```

### 7.2 Factory Pattern para Testing
```php
// database/factories/ClienteFactory.php
class ClienteFactory extends Factory
{
    public function definition()
    {
        return [
            'nombre' => $this->faker->company(),
            'direccion' => $this->faker->address(),
            'telefono' => $this->faker->phoneNumber(),
        ];
    }
}
```

### 7.3 Observer Pattern para Auditoria
```php
// Observadores para tracking automático
class PedidoObserver
{
    public function created(Pedido $pedido)
    {
        SystemLog::create([
            'action' => 'pedido_created',
            'model_id' => $pedido->id,
            'user_id' => auth()->id(),
        ]);
    }
}
```

---

## 8. Arquitectura de Seguridad

### 8.1 Autenticación y Autorización
```php
// Middleware stack
Route::middleware(['auth', 'verified'])->group(function () {
    // Rutas protegidas
});

// Spatie Permission para roles granulares
$user->assignRole('operador_ventas');
$user->can('crear_pedidos');
```

### 8.2 Validación de Datos
```php
// Form Requests para validación consistente
class StorePedidoRequest extends FormRequest
{
    public function rules()
    {
        return [
            'cliente_id' => 'required|exists:clientes,id',
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ];
    }
}
```

### 8.3 Protección CSRF y XSS
- **CSRF:** Tokens automáticos en todos los formularios
- **XSS:** Escape automático Blade templates
- **SQL Injection:** Eloquent ORM + prepared statements
- **Mass Assignment:** Fillable properties en models

---

## 9. Arquitectura de Performance

### 9.1 Estrategias de Optimización
```php
// Eager Loading para prevenir N+1
$pedidos = Pedido::with(['cliente', 'items.producto'])->get();

// Índices de base de datos optimizados
Schema::table('productos', function (Blueprint $table) {
    $table->index(['nombre', 'sku']); // Búsquedas frecuentes
    $table->index('stock_actual');    // Validaciones de stock
});

// Paginación para listas grandes
$clientes = Cliente::paginate(20);
```

### 9.2 Caching Strategy (Futuro)
```php
// Cache de consultas frecuentes
$productos = Cache::remember('productos_activos', 3600, function () {
    return Producto::where('stock_actual', '>', 0)->get();
});
```

---

## 10. Arquitectura de Testing

### 10.1 Estrategia de Testing
```php
// Feature Tests para flujos completos
class PedidoTest extends TestCase
{
    /** @test */
    public function puede_crear_pedido_completo()
    {
        $cliente = Cliente::factory()->create();
        $producto = Producto::factory()->create(['stock_actual' => 10]);
        
        $response = $this->post('/pedidos', [
            'cliente_id' => $cliente->id,
            'productos' => [
                ['id' => $producto->id, 'cantidad' => 5]
            ]
        ]);
        
        $response->assertRedirect();
        $this->assertDatabaseHas('pedidos', [
            'cliente_id' => $cliente->id
        ]);
    }
}
```

### 10.2 Unit Tests para Lógica de Negocio
```php
class DescuentoTest extends TestCase
{
    /** @test */
    public function calcula_descuento_nivel_2_correctamente()
    {
        $calculadora = new CalculadoraDescuento();
        $monto = 15000; // Supera umbral L2
        
        $nivel = $calculadora->determinarNivel($monto);
        
        $this->assertEquals('L2', $nivel->codigo);
        $this->assertEquals(5, $nivel->porcentaje);
    }
}
```

---

## 11. Evolución Arquitectónica

### 11.1 Debt Técnico Identificado
1. **Models directos en Controllers:** Migrar a Repository Pattern
2. **Lógica de negocio en Controllers:** Extraer a Service Layer
3. **Cache básico:** Implementar Redis para mejor performance
4. **Monitoreo limitado:** Agregar observabilidad completa

### 11.2 Roadmap Arquitectónico

**Fase Actual (v1.0):**
- ✅ Arquitectura híbrida funcional
- ✅ Base de datos optimizada
- ✅ Sistema de búsqueda robusto

**Fase 2 (v2.0):**
- 🔄 Repository Pattern implementado
- 🔄 Service Layer para lógica compleja
- 🔄 Cache Layer con Redis
- 🔄 API REST completa

**Fase 3 (v3.0):**
- 📋 Microservicios para módulos independientes
- 📋 Frontend SPA con Vue.js/React
- 📋 Message Queues para operaciones asíncronas
- 📋 Observabilidad completa (logs, métricas, trazas)

---

## 12. Consideraciones de Deployment

### 12.1 Entornos de Desarrollo
```yaml
Local: Laragon + SQLite + File Cache
Staging: Docker + MySQL + Redis Cache  
Production: VPS + MySQL + Redis + Queue Workers
```

### 12.2 Configuración de Producción
```php
// .env.production
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=mysql
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

// Optimizaciones de producción
php artisan config:cache
php artisan route:cache  
php artisan view:cache
php artisan optimize
```

---

## 13. Documentación de APIs

### 13.1 APIs Internas Implementadas
```yaml
GET /api/search/clientes?q={term}:
  description: Autocomplete de clientes
  response: JSON con id, nombre, direccion, telefono

GET /api/search/productos?q={term}:
  description: Autocomplete de productos  
  response: JSON con id, nombre, sku, precio, stock
```

### 13.2 APIs Futuras (Roadmap)
```yaml
REST API Completa:
  - GET /api/pedidos - Lista de pedidos
  - POST /api/pedidos - Crear pedido
  - PUT /api/pedidos/{id} - Actualizar pedido
  - DELETE /api/pedidos/{id} - Eliminar pedido
  
GraphQL API:
  - Query flexible para reportes
  - Subscriptions para tiempo real
```

---

## Conclusiones Arquitectónicas

### Fortalezas de la Arquitectura Actual
1. **Pragmática:** Equilibrio entre simplicidad y funcionalidad
2. **Escalable:** Base sólida para crecimiento futuro
3. **Mantenible:** Separación clara de responsabilidades
4. **Testeable:** Estructura que facilita testing automatizado

### Lecciones Aprendidas Críticas
1. **Híbrido es efectivo:** Combinar Livewire + Controllers tradicionales
2. **Scout + Fallback:** Búsqueda robusta sin dependencias críticas
3. **SoftDeletes esencial:** Preservación de datos históricos crítica
4. **Modularidad paga:** Separación de módulos facilita mantenimiento

### Recomendaciones para Futuros Proyectos
1. **Empezar híbrido:** Livewire solo donde agregue valor real
2. **Inversión en testing:** Cobertura alta desde el inicio
3. **Documentación continua:** Actualizar con cada cambio arquitectónico
4. **Performance desde día 1:** Índices y consultas optimizadas

---

**Documento preparado por:** Arquitecto de Software Sistema BAMBU  
**Revisado por:** Lead Developer y CTO  
**Última actualización:** 30 de Julio, 2025  
**Estado:** ✅ **VALIDADO** - Arquitectura en producción estable