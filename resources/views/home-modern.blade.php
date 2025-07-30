@extends('layouts.app')

@section('title', 'Sistema BAMBU')

@push('styles')
    <style>
        /* TEMA OSCURO COMPLETO - Override total de Bootstrap */
        body.home-modern {
            background: linear-gradient(135deg, #0f0f23 0%, #16213e 100%) !important;
            color: #f8fafc !important;
            min-height: 100vh !important;
        }
        
        /* Container expandido para usar mejor el espacio */
        .container {
            max-width: 1400px !important;
            width: 95% !important;
        }
        
        /* Navbar completamente oscura */
        .navbar {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%) !important;
            border-bottom: 1px solid #8B5CF6 !important;
            backdrop-filter: blur(10px) !important;
        }
        
        .navbar-brand, .nav-link, .dropdown-item {
            color: #f8fafc !important;
            font-weight: 500 !important;
        }
        
        .nav-link:hover, .dropdown-item:hover {
            color: #c4b5fd !important;
            background-color: rgba(139, 92, 246, 0.1) !important;
        }
        
        .dropdown-menu {
            background-color: #1a1a2e !important;
            border: 1px solid #2a2d47 !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
        }
        
        /* Header principal - más compacto */
        .hero-section {
            text-align: center;
            margin-bottom: 2rem;
            padding: 1rem 0;
        }
        
        .hero-title {
            color: #f8fafc !important;
            font-size: 2.5rem !important;
            font-weight: 700 !important;
            margin-bottom: 0.5rem !important;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        
        .hero-subtitle {
            color: #94a3b8 !important;
            font-size: 1rem !important;
            margin-bottom: 1rem !important;
        }
        
        .hero-badge {
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.2) 0%, rgba(124, 58, 237, 0.2) 100%) !important;
            color: #c4b5fd !important;
            border: 1px solid rgba(139, 92, 246, 0.4) !important;
            padding: 0.5rem 1rem !important;
            border-radius: 0.5rem !important;
            font-weight: 500 !important;
            font-size: 0.875rem !important;
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.2) !important;
        }
        
        /* Cards compactas y más cuadradas */
        .modern-dashboard-card {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%) !important;
            border: 1px solid rgba(139, 92, 246, 0.2) !important;
            border-radius: 0.5rem !important;
            padding: 1.25rem 1.25rem 1.5rem 1.25rem !important;
            height: 270px !important;
            display: flex !important;
            flex-direction: column !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2) !important;
            position: relative !important;
            overflow: hidden !important;
        }
        
        .modern-dashboard-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #8B5CF6, #c4b5fd, #8B5CF6);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .modern-dashboard-card:hover {
            transform: translateY(-4px) !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3) !important;
            border-color: rgba(139, 92, 246, 0.4) !important;
        }
        
        .modern-dashboard-card:hover::before {
            opacity: 1;
        }
        
        /* Iconos de las cards - más compactos */
        .card-icon {
            font-size: 2rem !important;
            color: #8B5CF6 !important;
            margin-bottom: 0.75rem !important;
            display: block !important;
        }
        
        /* Títulos de las cards - más compactos */
        .card-title {
            color: #f8fafc !important;
            font-size: 1.25rem !important;
            font-weight: 600 !important;
            margin-bottom: 0.5rem !important;
            line-height: 1.2 !important;
        }
        
        /* Descripciones de las cards - más compactas */
        .card-description {
            color: #94a3b8 !important;
            font-size: 0.8rem !important;
            line-height: 1.4 !important;
            margin-bottom: 1rem !important;
            flex: 1 !important;
        }
        
        /* Botones más cuadrados */
        .modern-btn-primary {
            background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%) !important;
            border: none !important;
            color: white !important;
            padding: 0.5rem 1rem !important;
            border-radius: 0.375rem !important;
            font-weight: 500 !important;
            font-size: 0.875rem !important;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
            display: inline-block !important;
            box-shadow: 0 3px 8px rgba(139, 92, 246, 0.3) !important;
            margin-bottom: 0.375rem !important;
            width: 100% !important;
            text-align: center !important;
        }
        
        .modern-btn-primary:hover {
            background: linear-gradient(135deg, #7C3AED 0%, #6D28D9 100%) !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 6px 15px rgba(139, 92, 246, 0.4) !important;
            color: white !important;
        }
        
        .modern-btn-secondary {
            background: rgba(139, 92, 246, 0.1) !important;
            border: 1px solid rgba(139, 92, 246, 0.3) !important;
            color: #c4b5fd !important;
            padding: 0.5rem 1rem !important;
            border-radius: 0.375rem !important;
            font-weight: 500 !important;
            font-size: 0.875rem !important;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
            display: inline-block !important;
            width: 100% !important;
            text-align: center !important;
        }
        
        .modern-btn-secondary:hover {
            background: rgba(139, 92, 246, 0.2) !important;
            border-color: rgba(139, 92, 246, 0.5) !important;
            color: #f8fafc !important;
            transform: translateY(-1px) !important;
        }
        
        /* Estado del sistema - más cuadrado */
        .system-status {
            background: linear-gradient(135deg, #16213e 0%, #1a1a2e 100%) !important;
            border: 1px solid rgba(139, 92, 246, 0.2) !important;
            border-radius: 0.5rem !important;
            padding: 1.5rem !important;
            margin-top: 2rem !important;
        }
        
        .system-status h6 {
            color: #f8fafc !important;
            font-weight: 600 !important;
            margin-bottom: 0.75rem !important;
            font-size: 1rem !important;
        }
        
        .system-status .progress {
            background-color: #2a2d47 !important;
            height: 6px !important;
            border-radius: 3px !important;
            margin-bottom: 1rem !important;
        }
        
        .system-status .progress-bar {
            background: linear-gradient(90deg, #8B5CF6 0%, #c4b5fd 100%) !important;
            border-radius: 4px !important;
        }
        
        .system-status .small {
            color: #94a3b8 !important;
            font-size: 0.8rem !important;
        }
        
        .system-status strong {
            color: #f8fafc !important;
        }
        
        /* Grid más denso */
        .row.g-4 {
            --bs-gutter-x: 1rem !important;
            --bs-gutter-y: 1rem !important;
        }
        
        /* Responsividad mejorada */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem !important;
            }
            
            .container {
                width: 98% !important;
            }
            
            .modern-dashboard-card {
                height: auto !important;
                min-height: 200px !important;
                padding: 1.25rem !important;
            }
        }
        
        /* Navbar responsive fix */
        @media (min-width: 992px) {
            .navbar-nav {
                gap: 0.5rem;
            }
        }
        
        /* Botón hamburguesa moderno */
        .navbar-toggler {
            border: 1px solid rgba(139, 92, 246, 0.3) !important;
            border-radius: 0.375rem !important;
            padding: 0.5rem !important;
            background: rgba(139, 92, 246, 0.1) !important;
            transition: all 0.3s ease !important;
        }
        
        .navbar-toggler:hover {
            background: rgba(139, 92, 246, 0.2) !important;
            border-color: rgba(139, 92, 246, 0.5) !important;
            transform: scale(1.05) !important;
        }
        
        .navbar-toggler:focus {
            box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.3) !important;
            outline: none !important;
        }
        
        /* Icono hamburguesa personalizado - corregido */
        .navbar-toggler-icon {
            background-image: none !important;
            width: 20px !important;
            height: 14px !important;
            position: relative !important;
            display: inline-block !important;
        }
        
        /* Crear las 3 líneas del hamburger */
        .navbar-toggler-icon::before,
        .navbar-toggler-icon::after {
            content: '';
            position: absolute;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #f8fafc !important;
            border-radius: 1px;
            transition: all 0.3s ease;
        }
        
        .navbar-toggler-icon::before {
            top: 0;
        }
        
        .navbar-toggler-icon::after {
            bottom: 0;
        }
        
        /* Línea del medio */
        .navbar-toggler-icon {
            background-color: #f8fafc !important;
            height: 2px !important;
            border-radius: 1px !important;
        }
        
        .navbar-toggler-icon::before,
        .navbar-toggler-icon::after {
            display: block !important;
        }
        
        /* Estado por defecto (cerrado) - las 3 líneas visibles */
        .navbar-toggler[aria-expanded="false"] .navbar-toggler-icon::before {
            transform: translateY(0) rotate(0deg);
        }
        
        .navbar-toggler[aria-expanded="false"] .navbar-toggler-icon::after {
            transform: translateY(0) rotate(0deg);
        }
        
        .navbar-toggler[aria-expanded="false"] .navbar-toggler-icon {
            opacity: 1;
        }
        
        /* Estado abierto - transformar en X */
        .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon::before {
            transform: translateY(6px) rotate(45deg);
        }
        
        .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon::after {
            transform: translateY(-6px) rotate(-45deg);
        }
        
        .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon {
            opacity: 0;
        }
    </style>
@endpush

@section('content')
<script>
    // Aplicar tema oscuro al cargar la página
    document.body.classList.add('home-modern');
</script>

<!-- Hero Section -->
<div class="hero-section">
    <h1 class="hero-title">
        <i class="bi bi-boxes me-3"></i>Sistema BAMBU
    </h1>
    <p class="hero-subtitle">
        Sistema de Gestión Integral para Productos Químicos de Limpieza
    </p>
    <div>
        <span class="hero-badge">
            <i class="bi bi-shield-check me-2"></i>Río Negro & Neuquén
        </span>
    </div>
</div>

<!-- Dashboard Cards Grid -->
<div class="row g-3 mb-4">
    <div class="col-lg-4 col-md-6">
        <div class="modern-dashboard-card">
            <i class="bi bi-people card-icon"></i>
            <h3 class="card-title">Gestión de Clientes</h3>
            <p class="card-description">Administra tu cartera de clientes con información completa y búsqueda rápida por toda la región.</p>
            <div class="mt-auto">
                <a href="{{ route('clientes.index') }}" class="modern-btn-primary">
                    <i class="bi bi-eye me-2"></i>Ver Clientes
                </a>
                <a href="{{ route('clientes.create') }}" class="modern-btn-secondary">
                    <i class="bi bi-plus me-2"></i>Nuevo Cliente
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6">
        <div class="modern-dashboard-card">
            <i class="bi bi-box-seam card-icon"></i>
            <h3 class="card-title">Control de Productos</h3>
            <p class="card-description">Gestiona tu inventario BAMBU y Saphirus con control de stock en tiempo real y precios dinámicos.</p>
            <div class="mt-auto">
                <a href="{{ route('productos.index') }}" class="modern-btn-primary">
                    <i class="bi bi-eye me-2"></i>Ver Productos
                </a>
                <a href="{{ route('productos.create') }}" class="modern-btn-secondary">
                    <i class="bi bi-plus me-2"></i>Nuevo Producto
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6">
        <div class="modern-dashboard-card">
            <i class="bi bi-truck card-icon"></i>
            <h3 class="card-title">Logística de Repartos</h3>
            <p class="card-description">Planifica entregas con control de vehículos, rutas optimizadas y seguimiento en tiempo real.</p>
            <div class="mt-auto">
                <a href="{{ route('repartos.index') }}" class="modern-btn-primary">
                    <i class="bi bi-calendar-check me-2"></i>Planificar Repartos
                </a>
                <a href="{{ route('seguimiento.entregas') }}" class="modern-btn-secondary">
                    <i class="bi bi-geo-alt me-2"></i>Seguimiento
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-4 col-md-6">
        <div class="modern-dashboard-card">
            <i class="bi bi-calculator card-icon"></i>
            <h3 class="card-title">Cotizador Inteligente</h3>
            <p class="card-description">Crea cotizaciones inteligentes con descuentos automáticos por volumen y validación de stock.</p>
            <div class="mt-auto">
                <a href="{{ route('cotizador') }}" class="modern-btn-primary">
                    <i class="bi bi-calculator me-2"></i>Crear Cotización
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6">
        <div class="modern-dashboard-card">
            <i class="bi bi-receipt card-icon"></i>
            <h3 class="card-title">Control de Pedidos</h3>
            <p class="card-description">Gestiona pedidos confirmados con seguimiento de estado y movimientos de stock.</p>
            <div class="mt-auto">
                <a href="{{ route('pedidos.index') }}" class="modern-btn-primary">
                    <i class="bi bi-receipt me-2"></i>Ver Pedidos
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6">
        <div class="modern-dashboard-card">
            <i class="bi bi-gear card-icon"></i>
            <h3 class="card-title">Administración</h3>
            <p class="card-description">Accede al panel completo de configuración del sistema y gestión avanzada.</p>
            <div class="mt-auto">
                <a href="/admin" target="_blank" class="modern-btn-primary">
                    <i class="bi bi-box-arrow-up-right me-2"></i>Panel Admin
                </a>
            </div>
        </div>
    </div>
</div>

<!-- System Status -->
<div class="system-status">
    <h6><i class="bi bi-info-circle-fill me-2"></i>Estado del Sistema</h6>
    <div class="progress mb-3">
        <div class="progress-bar" style="width: 95%;"></div>
    </div>
    <div class="small">
        <div class="row">
            <div class="col-md-6">
                <strong>✅ Fase 1 Completada:</strong> CRUD completo de clientes, productos y ciudades con búsqueda integrada<br>
                <strong>✅ Fase 2 Completada:</strong> Cotizador inteligente con descuentos automáticos por volumen
            </div>
            <div class="col-md-6">
                <strong>✅ Fase 3A Completada:</strong> Sistema completo de logística y repartos con seguimiento<br>
                <strong>🎯 Sistema Operativo:</strong> Listo para producción con datos reales de Río Negro y Neuquén
            </div>
        </div>
    </div>
</div>
@endsection