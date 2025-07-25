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

