@extends('layouts.app-modern')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Resumen ejecutivo del sistema de gestión BAMBU')

@section('header-actions')
    <div class="flex items-center space-x-3">
        <a href="{{ route('cotizador') }}" class="btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
            </svg>
            Nueva Cotización
        </a>
    </div>
@endsection

@section('content')
    <!-- Métricas principales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Pedidos Hoy -->
        <div class="card-primary p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-text-muted">Pedidos Hoy</p>
                    <p class="text-3xl font-bold text-text-primary">{{ \DB::table('pedidos')->whereDate('created_at', today())->count() }}</p>
                    <p class="text-xs text-green-400 flex items-center mt-2">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        +12% vs ayer
                    </p>
                </div>
                <div class="p-3 bg-primary-600 rounded-lg shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Facturación Mensual -->
        <div class="card-primary p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-text-muted">Facturación Mensual</p>
                    <p class="text-3xl font-bold text-text-primary">${{ number_format(\DB::table('pedidos')->whereMonth('created_at', now()->month)->sum('total'), 0, ',', '.') }}</p>
                    <p class="text-xs text-green-400 flex items-center mt-2">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        +8% vs mes anterior
                    </p>
                </div>
                <div class="p-3 bg-green-600 rounded-lg shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Entregas Pendientes -->
        <div class="card-primary p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-text-muted">Entregas Pendientes</p>
                    <p class="text-3xl font-bold text-text-primary">{{ \DB::table('repartos')->where('estado', 'planificado')->count() }}</p>
                    <p class="text-xs text-yellow-400 flex items-center mt-2">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Para hoy
                    </p>
                </div>
                <div class="p-3 bg-yellow-600 rounded-lg shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Stock Crítico -->
        <div class="card-primary p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-text-muted">Productos Stock Bajo</p>
                    <p class="text-3xl font-bold text-text-primary">{{ \DB::table('productos')->where('stock_actual', '<', 10)->count() }}</p>
                    <p class="text-xs text-red-400 flex items-center mt-2">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        Requiere atención
                    </p>
                </div>
                <div class="p-3 bg-red-600 rounded-lg shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido principal dividido en dos columnas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Últimos Pedidos -->
        <div class="card-primary">
            <div class="px-6 py-4 border-b border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-text-primary">Últimos Pedidos</h3>
                    <a href="{{ route('pedidos.index') }}" class="text-sm text-primary-400 hover:text-primary-300">Ver todos</a>
                </div>
            </div>
            <div class="overflow-hidden">
                <table class="table-dense">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\DB::table('pedidos')->join('clientes', 'pedidos.cliente_id', '=', 'clientes.id')->select('pedidos.*', 'clientes.nombre as cliente_nombre')->orderBy('pedidos.created_at', 'desc')->limit(5)->get() as $pedido)
                        <tr>
                            <td class="font-mono text-primary-400">#{{ str_pad($pedido->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="font-medium text-text-primary">{{ $pedido->cliente_nombre }}</td>
                            <td class="font-semibold text-text-primary">${{ number_format($pedido->total, 0, ',', '.') }}</td>
                            <td>
                                @if($pedido->estado === 'confirmado')
                                    <span class="badge-delivered">Confirmado</span>
                                @elseif($pedido->estado === 'pendiente')
                                    <span class="badge-planned">Pendiente</span>
                                @else
                                    <span class="badge-failed">{{ ucfirst($pedido->estado) }}</span>
                                @endif
                            </td>
                            <td class="text-text-muted">{{ \Carbon\Carbon::parse($pedido->created_at)->format('d/m/Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Estado de Flota -->
        <div class="card-primary">
            <div class="px-6 py-4 border-b border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-text-primary">Estado de Flota</h3>
                    <a href="{{ route('vehiculos.index') }}" class="text-sm text-primary-400 hover:text-primary-300">Administrar</a>
                </div>
            </div>
            <div class="p-6 space-y-4">
                @foreach(\DB::table('vehiculos')->get() as $vehiculo)
                <div class="flex items-center justify-between p-4 bg-gray-800 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-primary-600 rounded-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-text-primary">{{ $vehiculo->nombre }}</p>
                            <p class="text-sm text-text-muted">{{ $vehiculo->patente ?? 'Sin patente' }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-text-primary">{{ $vehiculo->capacidad_bultos }} bultos</p>
                        @php
                            $capacidadUsada = \DB::table('repartos')->where('vehiculo_id', $vehiculo->id)->whereDate('fecha_reparto', today())->sum('bultos_total') ?? 0;
                            $porcentajeUso = $vehiculo->capacidad_bultos > 0 ? ($capacidadUsada / $vehiculo->capacidad_bultos) * 100 : 0;
                        @endphp
                        <div class="flex items-center space-x-2 mt-1">
                            <div class="w-16 bg-gray-700 rounded-full h-2">
                                <div class="h-2 rounded-full {{ $porcentajeUso > 80 ? 'bg-red-500' : ($porcentajeUso > 60 ? 'bg-yellow-500' : 'bg-green-500') }}" style="width: {{ min($porcentajeUso, 100) }}%"></div>
                            </div>
                            <span class="text-xs text-text-muted">{{ round($porcentajeUso) }}%</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Acciones rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Gestión de Clientes -->
        <div class="card-primary p-6">
            <div class="flex items-center mb-4">
                <div class="p-3 bg-primary-600 rounded-lg mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-text-primary">Clientes</h3>
                    <p class="text-sm text-text-muted">{{ \DB::table('clientes')->count() }} registrados</p>
                </div>
            </div>
            <p class="text-sm text-text-secondary mb-4">Administra tu cartera de clientes con información completa de Río Negro y Neuquén.</p>
            <div class="space-y-2">
                <a href="{{ route('clientes.index') }}" class="block w-full btn-secondary text-center">
                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Ver Clientes
                </a>
                <a href="{{ route('clientes.create') }}" class="block w-full text-center px-4 py-2 text-sm font-medium text-primary-400 border border-primary-600/50 rounded-lg hover:bg-primary-600/10 transition-colors">
                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Nuevo Cliente
                </a>
            </div>
        </div>

        <!-- Control de Productos -->
        <div class="card-primary p-6">
            <div class="flex items-center mb-4">
                <div class="p-3 bg-green-600 rounded-lg mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-text-primary">Productos</h3>
                    <p class="text-sm text-text-muted">{{ \DB::table('productos')->count() }} en catálogo</p>
                </div>
            </div>
            <p class="text-sm text-text-secondary mb-4">Gestiona inventario BAMBU y Saphirus con control de stock en tiempo real.</p>
            <div class="space-y-2">
                <a href="{{ route('productos.index') }}" class="block w-full btn-secondary text-center">
                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Ver Productos
                </a>
                <a href="{{ route('productos.create') }}" class="block w-full text-center px-4 py-2 text-sm font-medium text-primary-400 border border-primary-600/50 rounded-lg hover:bg-primary-600/10 transition-colors">
                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Nuevo Producto
                </a>
            </div>
        </div>

        <!-- Logística de Repartos -->
        <div class="card-primary p-6">
            <div class="flex items-center mb-4">
                <div class="p-3 bg-yellow-600 rounded-lg mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-text-primary">Logística</h3>
                    <p class="text-sm text-text-muted">{{ \DB::table('vehiculos')->count() }} vehículos</p>
                </div>
            </div>
            <p class="text-sm text-text-secondary mb-4">Planifica entregas con control de flota y seguimiento en tiempo real.</p>
            <div class="space-y-2">
                <a href="{{ route('repartos.index') }}" class="block w-full btn-secondary text-center">
                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Planificar Repartos
                </a>
                <a href="{{ route('seguimiento.entregas') }}" class="block w-full text-center px-4 py-2 text-sm font-medium text-primary-400 border border-primary-600/50 rounded-lg hover:bg-primary-600/10 transition-colors">
                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Seguimiento
                </a>
            </div>
        </div>
    </div>

    <!-- Estado del sistema -->
    <div class="mt-8 card-primary p-6">
        <div class="flex items-center mb-4">
            <svg class="w-5 h-5 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="text-lg font-semibold text-text-primary">Estado del Sistema</h3>
        </div>
        
        <div class="mb-4">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-text-secondary">Implementación completa</span>
                <span class="text-sm font-medium text-green-400">95%</span>
            </div>
            <div class="w-full bg-gray-700 rounded-full h-2">
                <div class="bg-gradient-to-r from-primary-600 to-primary-500 h-2 rounded-full" style="width: 95%"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-green-400 font-medium mb-1">✅ Fase 1 Completada:</p>
                <p class="text-text-muted">CRUD completo de clientes, productos y ciudades con búsqueda integrada</p>
                
                <p class="text-green-400 font-medium mb-1 mt-3">✅ Fase 2 Completada:</p>
                <p class="text-text-muted">Cotizador inteligente con descuentos automáticos por volumen</p>
            </div>
            <div>
                <p class="text-green-400 font-medium mb-1">✅ Fase 3A Completada:</p>
                <p class="text-text-muted">Sistema completo de logística y repartos con seguimiento</p>
                
                <p class="text-primary-400 font-medium mb-1 mt-3">🎯 Sistema Operativo:</p>
                <p class="text-text-muted">Listo para producción con datos reales de Río Negro y Neuquén</p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Actualizar métricas cada 30 segundos (opcional)
    setInterval(function() {
        // Aquí podrías implementar actualización AJAX de las métricas
        // para dashboards en tiempo real
    }, 30000);
</script>
@endpush