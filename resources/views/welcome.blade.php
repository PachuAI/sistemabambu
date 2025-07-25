@extends('layouts.app')

@section('title', 'Sistema BAMBU')

@section('content')
<div class="text-center mb-5 bambu-fade-in">
    <h1 class="display-3 fw-bold" style="color: var(--bambu-primary);">
        <i class="bi bi-boxes me-3"></i>Sistema BAMBU
    </h1>
    <p class="lead" style="color: var(--bambu-gray-600); font-size: 1.3rem;">
        Sistema de Gestión Integral para Productos Químicos de Limpieza
    </p>
    <div class="mt-4">
        <span class="badge badge-bambu-primary px-3 py-2">
            <i class="bi bi-shield-check me-1"></i>Río Negro & Neuquén
        </span>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-lg-4 col-md-6">
        <div class="dashboard-card dashboard-card-fixed">
            <i class="bi bi-people"></i>
            <h3>Gestión de Clientes</h3>
            <p class="text-muted">Administra tu cartera de clientes con información completa y búsqueda rápida por toda la región.</p>
            <div class="d-grid gap-2 mt-auto">
                <a href="{{ route('clientes.index') }}" class="btn btn-bambu-primary btn-dashboard">
                    <i class="bi bi-eye me-1"></i>Ver Clientes
                </a>
                <a href="{{ route('clientes.create') }}" class="btn btn-bambu-outline btn-dashboard">
                    <i class="bi bi-plus me-1"></i>Nuevo Cliente
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6">
        <div class="dashboard-card dashboard-card-fixed">
            <i class="bi bi-box-seam"></i>
            <h3>Control de Productos</h3>
            <p class="text-muted">Gestiona tu inventario BAMBU y Saphirus con control de stock en tiempo real y precios dinámicos.</p>
            <div class="d-grid gap-2 mt-auto">
                <a href="{{ route('productos.index') }}" class="btn btn-bambu-primary btn-dashboard">
                    <i class="bi bi-eye me-1"></i>Ver Productos
                </a>
                <a href="{{ route('productos.create') }}" class="btn btn-bambu-outline btn-dashboard">
                    <i class="bi bi-plus me-1"></i>Nuevo Producto
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6">
        <div class="dashboard-card dashboard-card-fixed">
            <i class="bi bi-truck"></i>
            <h3>Logística de Repartos</h3>
            <p class="text-muted">Planifica entregas con control de vehículos, rutas optimizadas y seguimiento en tiempo real.</p>
            <div class="d-grid gap-2 mt-auto">
                <a href="{{ route('repartos.index') }}" class="btn btn-bambu-primary btn-dashboard">
                    <i class="bi bi-calendar-check me-1"></i>Planificar Repartos
                </a>
                <a href="{{ route('seguimiento.entregas') }}" class="btn btn-bambu-outline btn-dashboard">
                    <i class="bi bi-geo-alt me-1"></i>Seguimiento
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-lg-4 col-md-6">
        <div class="dashboard-card dashboard-card-fixed">
            <i class="bi bi-calculator"></i>
            <h3>Cotizador Inteligente</h3>
            <p class="text-muted">Crea cotizaciones inteligentes con descuentos automáticos por volumen y validación de stock.</p>
            <div class="d-grid gap-2 mt-auto">
                <a href="{{ route('cotizador') }}" class="btn btn-bambu-primary btn-dashboard">
                    <i class="bi bi-calculator me-1"></i>Crear Cotización
                </a>
                <div></div> <!-- Espaciador para mantener altura uniforme -->
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6">
        <div class="dashboard-card dashboard-card-fixed">
            <i class="bi bi-receipt"></i>
            <h3>Control de Pedidos</h3>
            <p class="text-muted">Gestiona pedidos confirmados con seguimiento de estado y movimientos de stock.</p>
            <div class="d-grid gap-2 mt-auto">
                <a href="{{ route('pedidos.index') }}" class="btn btn-bambu-primary btn-dashboard">
                    <i class="bi bi-receipt me-1"></i>Ver Pedidos
                </a>
                <div></div> <!-- Espaciador para mantener altura uniforme -->
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6">
        <div class="dashboard-card dashboard-card-fixed">
            <i class="bi bi-gear"></i>
            <h3>Administración</h3>
            <p class="text-muted">Accede al panel completo de configuración del sistema y gestión avanzada.</p>
            <div class="d-grid gap-2 mt-auto">
                <a href="/admin" target="_blank" class="btn btn-bambu-secondary btn-dashboard">
                    <i class="bi bi-box-arrow-up-right me-1"></i>Panel Admin
                </a>
                <div></div> <!-- Espaciador para mantener altura uniforme -->
            </div>
        </div>
    </div>
</div>

<div class="alert-bambu">
    <h6><i class="bi bi-info-circle-fill me-2"></i>Estado del Sistema</h6>
    <div class="progress mb-3" style="height: 8px; background-color: var(--bambu-gray-200);">
        <div class="progress-bar" style="width: 95%; background: linear-gradient(135deg, var(--bambu-primary) 0%, var(--bambu-primary-dark) 100%);">
        </div>
    </div>
    <div class="small">
        <div class="row">
            <div class="col-md-6">
                <strong>✅ Fase 1 Completada:</strong> CRUD completo de clientes, productos y ciudades con búsqueda integrada
                <br><strong>✅ Fase 2 Completada:</strong> Cotizador inteligente con descuentos automáticos por volumen
            </div>
            <div class="col-md-6">
                <strong>✅ Fase 3A Completada:</strong> Sistema completo de logística y repartos con seguimiento
                <br><strong>🎯 Sistema Operativo:</strong> Listo para producción con datos reales de Río Negro y Neuquén
            </div>
        </div>
    </div>
</div>
@endsection