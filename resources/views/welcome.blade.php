@extends('layouts.app')

@section('title', 'Sistema BAMBU')

@section('content')
<div class="text-center mb-5">
    <h1 class="display-4 fw-bold text-success">
        <i class="bi bi-boxes"></i> Sistema BAMBU
    </h1>
    <p class="lead text-muted">Sistema de Gestión Integral para Productos Químicos de Limpieza</p>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card h-100 border-success">
            <div class="card-body text-center">
                <div class="display-1 text-success mb-3">
                    <i class="bi bi-people"></i>
                </div>
                <h5 class="card-title">Gestión de Clientes</h5>
                <p class="card-text">Administra tu cartera de clientes con información completa y búsqueda rápida.</p>
                <div class="d-grid gap-2">
                    <a href="{{ route('clientes.index') }}" class="btn btn-success">
                        <i class="bi bi-eye"></i> Ver Clientes
                    </a>
                    <a href="{{ route('clientes.create') }}" class="btn btn-outline-success">
                        <i class="bi bi-plus"></i> Nuevo Cliente
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card h-100 border-info">
            <div class="card-body text-center">
                <div class="display-1 text-info mb-3">
                    <i class="bi bi-box-seam"></i>
                </div>
                <h5 class="card-title">Control de Productos</h5>
                <p class="card-text">Gestiona tu inventario con control de stock en tiempo real y precios dinámicos.</p>
                <div class="d-grid gap-2">
                    <a href="{{ route('productos.index') }}" class="btn btn-info">
                        <i class="bi bi-eye"></i> Ver Productos
                    </a>
                    <a href="{{ route('productos.create') }}" class="btn btn-outline-info">
                        <i class="bi bi-plus"></i> Nuevo Producto
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card h-100 border-warning">
            <div class="card-body text-center">
                <div class="display-1 text-warning mb-3">
                    <i class="bi bi-calculator"></i>
                </div>
                <h5 class="card-title">Cotizador</h5>
                <p class="card-text">Crea cotizaciones inteligentes con descuentos automáticos por volumen.</p>
                <div class="d-grid gap-2">
                    <a href="{{ route('cotizador') }}" class="btn btn-warning">
                        <i class="bi bi-calculator"></i> Crear Cotización
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-4">
    <div class="col-md-6">
        <div class="card border-secondary">
            <div class="card-body text-center">
                <div class="display-2 text-secondary mb-3">
                    <i class="bi bi-truck"></i>
                </div>
                <h5 class="card-title">Logística de Repartos</h5>
                <p class="card-text">Organiza y planifica las entregas con control de rutas y vehículos.</p>
                <button class="btn btn-secondary" disabled>
                    <i class="bi bi-tools"></i> En Desarrollo
                </button>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card border-dark">
            <div class="card-body text-center">
                <div class="display-2 text-dark mb-3">
                    <i class="bi bi-gear"></i>
                </div>
                <h5 class="card-title">Panel de Administración</h5>
                <p class="card-text">Accede al panel completo de configuración del sistema.</p>
                <a href="/admin" target="_blank" class="btn btn-dark">
                    <i class="bi bi-box-arrow-up-right"></i> Abrir Admin
                </a>
            </div>
        </div>
    </div>
</div>

<div class="alert alert-info mt-5">
    <h6><i class="bi bi-info-circle"></i> Estado del Proyecto</h6>
    <div class="progress mb-2">
        <div class="progress-bar bg-success" style="width: 65%"></div>
    </div>
    <small>
        <strong>Fase 1 Completada:</strong> Sistema base con CRUD de clientes y productos, búsqueda integrada y panel de administración funcional.
        <br><strong>Fase 2 Completada:</strong> Cotizador Livewire con búsqueda en tiempo real, descuentos automáticos y generación de resúmenes.
        <br><strong>Próximo:</strong> Sistema de logística y repartos.
    </small>
</div>
@endsection