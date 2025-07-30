@extends('layouts.app')

@section('title', 'Dashboard Moderno - Test')

@push('styles')
    <link href="{{ asset('css/modern-ui.css') }}" rel="stylesheet">
@endpush

@section('content')
<script>
    // Agregar clase al body para aplicar tema oscuro
    document.body.classList.add('modern-ui');
</script>

<!-- Banner informativo -->
<div class="alert alert-info mb-4">
    <i class="bi bi-info-circle me-2"></i>
    <strong>Vista de Prueba:</strong> Esta es una versión moderna del dashboard con tema oscuro y diseño más denso.
</div>

<!-- Contenedor híbrido: Bootstrap para estructura, CSS moderno para componentes internos -->
<div class="container-fluid px-0">
    
    <!-- Título con estilo híbrido -->
    <div class="modern-card-primary modern-p-6 modern-mb-6">
        <h1 class="display-4 fw-bold modern-text-primary mb-2">
            <i class="bi bi-boxes modern-text-primary-color me-3"></i>Sistema BAMBU
        </h1>
        <p class="lead modern-text-secondary">
            Dashboard Moderno - Gestión Integral de Productos Químicos
        </p>
    </div>

    <!-- Métricas principales - Grid Bootstrap con cards Tailwind -->
    <div class="row g-4 mb-5">
        <!-- Pedidos Hoy -->
        <div class="col-lg-3 col-md-6">
            <div class="modern-card-primary modern-p-6 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="small modern-text-muted mb-1">Pedidos Hoy</p>
                        <p class="display-6 fw-bold modern-text-primary mb-0">
                            {{ \DB::table('pedidos')->whereDate('created_at', today())->count() }}
                        </p>
                        <p class="small text-success mb-0 d-flex align-items-center mt-2">
                            <i class="bi bi-arrow-up-short fs-5"></i>
                            +12% vs ayer
                        </p>
                    </div>
                    <div class="p-3 bg-primary rounded modern-shadow-lg">
                        <i class="bi bi-bag-check fs-3 text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Facturación Mensual -->
        <div class="col-lg-3 col-md-6">
            <div class="tw-card-primary tw-p-6 tw-h-full">
                <div class="tw-flex tw-items-center tw-justify-between">
                    <div>
                        <p class="tw-text-sm tw-text-gray-400">Facturación Mes</p>
                        <p class="tw-text-3xl tw-font-bold tw-text-gray-100">
                            ${{ number_format(\DB::table('pedidos')->whereMonth('created_at', now()->month)->sum('monto_final'), 0, ',', '.') }}
                        </p>
                        <p class="tw-text-xs tw-text-green-400 tw-flex tw-items-center tw-mt-2">
                            <i class="bi bi-arrow-up-short tw-text-lg"></i>
                            +8% vs mes anterior
                        </p>
                    </div>
                    <div class="tw-p-3 tw-bg-green-600 tw-rounded-lg tw-shadow-lg">
                        <i class="bi bi-currency-dollar tw-text-2xl tw-text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Entregas Pendientes -->
        <div class="col-lg-3 col-md-6">
            <div class="tw-card-primary tw-p-6 tw-h-full">
                <div class="tw-flex tw-items-center tw-justify-between">
                    <div>
                        <p class="tw-text-sm tw-text-gray-400">Entregas Pendientes</p>
                        <p class="tw-text-3xl tw-font-bold tw-text-gray-100">
                            {{ \DB::table('repartos')->where('estado', 'planificado')->count() }}
                        </p>
                        <p class="tw-text-xs tw-text-yellow-400 tw-flex tw-items-center tw-mt-2">
                            <i class="bi bi-clock tw-text-sm tw-mr-1"></i>
                            Para hoy
                        </p>
                    </div>
                    <div class="tw-p-3 tw-bg-yellow-600 tw-rounded-lg tw-shadow-lg">
                        <i class="bi bi-truck tw-text-2xl tw-text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock Crítico -->
        <div class="col-lg-3 col-md-6">
            <div class="tw-card-primary tw-p-6 tw-h-full">
                <div class="tw-flex tw-items-center tw-justify-between">
                    <div>
                        <p class="tw-text-sm tw-text-gray-400">Stock Bajo</p>
                        <p class="tw-text-3xl tw-font-bold tw-text-gray-100">
                            {{ \DB::table('productos')->where('stock_actual', '<', 10)->count() }}
                        </p>
                        <p class="tw-text-xs tw-text-red-400 tw-flex tw-items-center tw-mt-2">
                            <i class="bi bi-exclamation-triangle tw-text-sm tw-mr-1"></i>
                            Requiere atención
                        </p>
                    </div>
                    <div class="tw-p-3 tw-bg-red-600 tw-rounded-lg tw-shadow-lg">
                        <i class="bi bi-box-seam tw-text-2xl tw-text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de contenido principal -->
    <div class="row g-4">
        <!-- Últimos Pedidos - Tabla híbrida -->
        <div class="col-lg-8">
            <div class="tw-card-primary tw-overflow-hidden">
                <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-700">
                    <div class="tw-flex tw-items-center tw-justify-between">
                        <h3 class="tw-text-lg tw-font-semibold tw-text-gray-100">Últimos Pedidos</h3>
                        <a href="{{ route('pedidos.index') }}" class="tw-text-sm tw-text-bambu-primary hover:tw-text-bambu-primary-light tw-transition-colors">
                            Ver todos <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="tw-overflow-x-auto">
                    <table class="tw-table-dense">
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
                            @php
                                $pedidos = \DB::table('pedidos')
                                    ->join('clientes', 'pedidos.cliente_id', '=', 'clientes.id')
                                    ->select('pedidos.*', 'clientes.nombre as cliente_nombre')
                                    ->orderBy('pedidos.created_at', 'desc')
                                    ->limit(5)
                                    ->get();
                            @endphp
                            @foreach($pedidos as $pedido)
                            <tr>
                                <td class="tw-font-mono tw-text-bambu-primary">#{{ str_pad($pedido->id, 3, '0', STR_PAD_LEFT) }}</td>
                                <td class="tw-font-medium tw-text-gray-100">{{ $pedido->cliente_nombre }}</td>
                                <td class="tw-font-semibold tw-text-gray-100">${{ number_format($pedido->monto_final, 0, ',', '.') }}</td>
                                <td>
                                    @if($pedido->estado === 'confirmado')
                                        <span class="tw-badge-delivered">Confirmado</span>
                                    @elseif($pedido->estado === 'pendiente')
                                        <span class="tw-badge-planned">Pendiente</span>
                                    @else
                                        <span class="tw-badge-failed">{{ ucfirst($pedido->estado) }}</span>
                                    @endif
                                </td>
                                <td class="tw-text-gray-400">{{ \Carbon\Carbon::parse($pedido->created_at)->format('d/m/Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="col-lg-4">
            <div class="tw-card-primary tw-p-6">
                <h3 class="tw-text-lg tw-font-semibold tw-text-gray-100 tw-mb-4">Acciones Rápidas</h3>
                
                <div class="d-grid gap-3">
                    <a href="{{ route('cotizador') }}" class="tw-btn-primary tw-text-center tw-no-underline">
                        <i class="bi bi-calculator me-2"></i>Nueva Cotización
                    </a>
                    
                    <a href="{{ route('clientes.create') }}" class="tw-btn-secondary tw-text-center tw-no-underline">
                        <i class="bi bi-person-plus me-2"></i>Nuevo Cliente
                    </a>
                    
                    <a href="{{ route('productos.create') }}" class="tw-btn-secondary tw-text-center tw-no-underline">
                        <i class="bi bi-box-seam me-2"></i>Nuevo Producto
                    </a>
                    
                    <a href="{{ route('repartos.index') }}" class="tw-btn-secondary tw-text-center tw-no-underline">
                        <i class="bi bi-truck me-2"></i>Planificar Reparto
                    </a>
                </div>
            </div>

            <!-- Mini estado del sistema -->
            <div class="tw-card-secondary tw-p-4 tw-mt-4">
                <h4 class="tw-text-sm tw-font-semibold tw-text-gray-300 tw-mb-3">Estado del Sistema</h4>
                <div class="tw-space-y-2">
                    <div class="tw-flex tw-items-center tw-justify-between">
                        <span class="tw-text-xs tw-text-gray-400">Clientes</span>
                        <span class="tw-text-xs tw-font-medium tw-text-gray-300">{{ \DB::table('clientes')->count() }}</span>
                    </div>
                    <div class="tw-flex tw-items-center tw-justify-between">
                        <span class="tw-text-xs tw-text-gray-400">Productos</span>
                        <span class="tw-text-xs tw-font-medium tw-text-gray-300">{{ \DB::table('productos')->count() }}</span>
                    </div>
                    <div class="tw-flex tw-items-center tw-justify-between">
                        <span class="tw-text-xs tw-text-gray-400">Vehículos</span>
                        <span class="tw-text-xs tw-font-medium tw-text-gray-300">{{ \DB::table('vehiculos')->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Comparación visual -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="alert alert-secondary">
                <h5><i class="bi bi-palette me-2"></i>Comparación Visual</h5>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <strong>Bootstrap Original:</strong>
                        <div class="card mt-2">
                            <div class="card-body">
                                <h6 class="card-title">Card Bootstrap</h6>
                                <p class="card-text">Este es el estilo actual del sistema.</p>
                                <button class="btn btn-primary btn-sm">Botón Bootstrap</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <strong>Tailwind Moderno:</strong>
                        <div class="tw-card-primary tw-p-4 tw-mt-2">
                            <h6 class="tw-text-lg tw-font-semibold tw-text-gray-100 tw-mb-2">Card Tailwind</h6>
                            <p class="tw-text-gray-400 tw-text-sm">Este es el nuevo estilo propuesto.</p>
                            <button class="tw-btn-primary tw-text-sm">Botón Tailwind</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
    // Log para confirmar que JavaScript sigue funcionando
    console.log('Vista de prueba moderna cargada correctamente');
    
    // Ejemplo de interactividad que funciona con ambos frameworks
    document.querySelectorAll('.tw-card-primary').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.transition = 'transform 0.2s ease';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
</script>
@endsection