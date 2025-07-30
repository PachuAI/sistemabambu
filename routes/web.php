<?php

use App\Livewire\MostrarProductos;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CiudadController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RepartoController;
use App\Http\Controllers\VehiculoController;
use Illuminate\Support\Facades\Route;

// Rutas de autenticación
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Grupo de rutas protegidas
Route::middleware('auth')->group(function () {

Route::get('/', function () {
    try {
        return view('welcome');
    } catch (\Exception $e) {
        return response('Error: ' . $e->getMessage(), 500);
    }
});

Route::get('/test', function () {
    return 'Sistema funcionando correctamente';
});

// Ruta de prueba para UI moderno
Route::get('/test-modern', function () {
    return view('dashboard.test-modern');
})->name('test.modern');

// Ruta para home moderno
Route::get('/home-modern', function () {
    return view('home-modern');
})->name('home.modern');

// Ruta para clientes moderno
Route::get('/clientes-modern', function () {
    $clientes = \App\Models\Cliente::with('ciudad')->paginate(15);
    return view('clientes.index-modern', compact('clientes'));
})->name('clientes.modern');

// Ruta para detalle de cliente moderno
Route::get('/clientes/{cliente}/modern', function (\App\Models\Cliente $cliente) {
    $cliente->load('ciudad');
    return view('clientes.show-modern', compact('cliente'));
})->name('clientes.show.modern');

// Ruta para editar cliente moderno
Route::get('/clientes/{cliente}/edit-modern', function (\App\Models\Cliente $cliente) {
    $ciudades = \App\Models\Ciudad::orderBy('nombre')->get();
    return view('clientes.edit-modern', compact('cliente', 'ciudades'));
})->name('clientes.edit.modern');

// Ruta para crear cliente moderno
Route::get('/clientes/create-modern', function () {
    $ciudades = \App\Models\Ciudad::orderBy('nombre')->get();
    return view('clientes.create-modern', compact('ciudades'));
})->name('clientes.create.modern');

// Ruta para productos moderno
Route::get('/productos-modern', function () {
    $request = request();
    $query = \App\Models\Producto::query();

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
    
    return view('productos.index-modern', compact('productos'));
})->name('productos.modern');

// Ruta para crear producto moderno
Route::get('/productos/create-modern', function () {
    return view('productos.create-modern');
})->name('productos.create.modern');

Route::resource('ciudades',  CiudadController::class);
Route::resource('clientes',  ClienteController::class);
Route::resource('productos', ProductoController::class);
Route::delete('/productos-multiple', [ProductoController::class, 'deleteMultiple'])->name('productos.deleteMultiple');
Route::resource('vehiculos', VehiculoController::class);

// Pedidos
Route::get('/pedidos', [App\Http\Controllers\PedidoController::class, 'index'])->name('pedidos.index');
Route::get('/pedidos/{pedido}', [App\Http\Controllers\PedidoController::class, 'show'])->name('pedidos.show');
Route::put('/pedidos/{pedido}', [App\Http\Controllers\PedidoController::class, 'update'])->name('pedidos.update');
Route::delete('/pedidos/{pedido}', [App\Http\Controllers\PedidoController::class, 'destroy'])->name('pedidos.destroy');

// Repartos
Route::get('/repartos', [RepartoController::class, 'index'])->name('repartos.index');
Route::post('/repartos/asignar', [RepartoController::class, 'asignar'])->name('repartos.asignar');
Route::delete('/repartos/{reparto}/desasignar', [RepartoController::class, 'desasignar'])->name('repartos.desasignar');

// Seguimiento de entregas
Route::get('/seguimiento-entregas', [App\Http\Controllers\SeguimientoController::class, 'index'])->name('seguimiento.entregas');
Route::post('/seguimiento-entregas/{reparto}/cambiar-estado', [App\Http\Controllers\SeguimientoController::class, 'cambiarEstado'])->name('seguimiento.cambiar-estado');

// Logs del sistema
Route::get('/system-logs', [App\Http\Controllers\SystemLogController::class, 'index'])->name('system-logs.index');
Route::get('/productos-livewire', MostrarProductos::class);

// Cotizador tradicional con Livewire embebido
Route::get('/cotizador', function () {
    return view('cotizador-livewire');
})->name('cotizador');

// Test Livewire
Route::get('/test-livewire', \App\Livewire\TestComponent::class)->name('test-livewire');


// Cotizador tradicional para testing
Route::get('/cotizador-tradicional', [App\Http\Controllers\CotizadorController::class, 'index'])->name('cotizador.tradicional');

// API Routes for search
Route::prefix('api')->group(function () {
    Route::get('/search/clientes', [SearchController::class, 'clientes']);
    Route::get('/search/productos', [SearchController::class, 'productos']);
    Route::post('/cotizador/agregar-producto', [App\Http\Controllers\CotizadorAjaxController::class, 'agregarProducto']);
});

// Rutas de prueba (solo en desarrollo)
if (app()->environment('local')) {
    include __DIR__ . '/test-routes.php';
}

}); // Fin del grupo de rutas protegidas

