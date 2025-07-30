@extends('layouts.app')

@section('title', 'Productos')

@push('styles')
    <style>
        /* Aplicar tema moderno solo a esta página */
        body.productos-modern {
            background: linear-gradient(135deg, #0f0f23 0%, #16213e 100%) !important;
            color: #f8fafc !important;
            min-height: 100vh !important;
        }
        
        
        /* Header moderno */
        .modern-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1.5rem 0;
            max-width: 1400px;
            width: 95%;
            margin-left: auto;
            margin-right: auto;
        }
        
        .modern-title {
            color: #f8fafc !important;
            font-size: 2rem !important;
            font-weight: 700 !important;
            margin: 0 !important;
        }
        
        .modern-title i {
            color: #8B5CF6 !important;
            margin-right: 0.75rem !important;
        }
        
        /* Botón primario moderno */
        .modern-btn-primary {
            background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%) !important;
            border: none !important;
            color: white !important;
            padding: 0.75rem 1.5rem !important;
            border-radius: 0.5rem !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3) !important;
        }
        
        .modern-btn-primary:hover {
            background: linear-gradient(135deg, #7C3AED 0%, #6D28D9 100%) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 20px rgba(139, 92, 246, 0.4) !important;
            color: white !important;
        }
        
        /* Card tabla moderna */
        .modern-table-card {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%) !important;
            border: 1px solid rgba(139, 92, 246, 0.2) !important;
            border-radius: 0.5rem !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2) !important;
            overflow: hidden !important;
            max-width: 1400px !important;
            width: 95% !important;
            margin: 0 auto !important;
        }
        
        /* Header de tabla */
        .table-header {
            padding: 1.25rem 1.5rem !important;
            border-bottom: 1px solid rgba(42, 45, 71, 0.5) !important;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
        }
        
        .table-title {
            color: #f8fafc !important;
            font-size: 1.125rem !important;
            font-weight: 600 !important;
            margin: 0 !important;
        }
        
        .table-meta {
            color: #94a3b8 !important;
            font-size: 0.875rem !important;
        }
        
        /* Tabla moderna */
        .modern-table {
            width: 100% !important;
            margin: 0 !important;
            color: #f8fafc !important;
        }
        
        .modern-table thead {
            background: linear-gradient(135deg, #16213e 0%, #1a1a2e 100%) !important;
        }
        
        .modern-table th {
            color: #94a3b8 !important;
            font-weight: 600 !important;
            font-size: 0.8rem !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            padding: 0.875rem 1rem !important;
            border: none !important;
            text-align: left !important;
        }
        
        .modern-table tbody tr {
            border-bottom: 1px solid rgba(42, 45, 71, 0.3) !important;
            transition: background-color 0.2s ease !important;
        }
        
        .modern-table tbody tr:hover {
            background-color: rgba(22, 33, 62, 0.5) !important;
        }
        
        .modern-table td {
            padding: 0.875rem 1rem !important;
            border: none !important;
            color: #cbd5e1 !important;
            font-size: 0.875rem !important;
            vertical-align: middle !important;
        }
        
        /* Producto info con avatar */
        .product-info {
            display: flex !important;
            align-items: center !important;
        }
        
        .product-avatar {
            width: 2.5rem !important;
            height: 2.5rem !important;
            background: #8B5CF6 !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin-right: 0.75rem !important;
            font-weight: 600 !important;
            color: white !important;
            font-size: 0.875rem !important;
        }
        
        .product-name {
            color: #f8fafc !important;
            font-weight: 600 !important;
            margin-bottom: 0.125rem !important;
        }
        
        .product-sku {
            color: #94a3b8 !important;
            font-size: 0.75rem !important;
        }
        
        /* Badge de stock moderna */
        .modern-stock-badge {
            padding: 0.25rem 0.75rem !important;
            border-radius: 0.375rem !important;
            font-size: 0.75rem !important;
            font-weight: 500 !important;
            display: inline-block !important;
        }
        
        .modern-stock-badge.high {
            background: rgba(16, 185, 129, 0.2) !important;
            color: #86efac !important;
            border: 1px solid rgba(16, 185, 129, 0.3) !important;
        }
        
        .modern-stock-badge.low {
            background: rgba(245, 158, 11, 0.2) !important;
            color: #fbbf24 !important;
            border: 1px solid rgba(245, 158, 11, 0.3) !important;
        }
        
        .modern-stock-badge.out {
            background: rgba(239, 68, 68, 0.2) !important;
            color: #fca5a5 !important;
            border: 1px solid rgba(239, 68, 68, 0.3) !important;
        }
        
        /* Badge de marca */
        .modern-brand-badge {
            padding: 0.25rem 0.75rem !important;
            border-radius: 0.375rem !important;
            font-size: 0.75rem !important;
            font-weight: 500 !important;
            display: inline-block !important;
        }
        
        .modern-brand-badge.bambu {
            background: rgba(16, 185, 129, 0.2) !important;
            color: #86efac !important;
            border: 1px solid rgba(16, 185, 129, 0.3) !important;
        }
        
        .modern-brand-badge.saphirus {
            background: rgba(59, 130, 246, 0.2) !important;
            color: #93c5fd !important;
            border: 1px solid rgba(59, 130, 246, 0.3) !important;
        }
        
        /* Badge de tipo */
        .modern-type-badge {
            padding: 0.25rem 0.75rem !important;
            border-radius: 0.375rem !important;
            font-size: 0.75rem !important;
            font-weight: 500 !important;
            display: inline-block !important;
        }
        
        .modern-type-badge.combo {
            background: rgba(245, 158, 11, 0.2) !important;
            color: #fbbf24 !important;
            border: 1px solid rgba(245, 158, 11, 0.3) !important;
        }
        
        .modern-type-badge.individual {
            background: rgba(139, 92, 246, 0.2) !important;
            color: #c4b5fd !important;
            border: 1px solid rgba(139, 92, 246, 0.3) !important;
        }
        
        /* Precio */
        .product-price {
            color: #10b981 !important;
            font-weight: 600 !important;
            font-size: 0.95rem !important;
        }
        
        /* Botones de acción modernos */
        .modern-action-group {
            display: flex !important;
            gap: 0.25rem !important;
        }
        
        .modern-action-btn {
            background: rgba(139, 92, 246, 0.1) !important;
            border: 1px solid rgba(139, 92, 246, 0.3) !important;
            color: #c4b5fd !important;
            padding: 0.5rem !important;
            border-radius: 0.375rem !important;
            transition: all 0.2s ease !important;
            text-decoration: none !important;
        }
        
        .modern-action-btn:hover {
            background: rgba(139, 92, 246, 0.2) !important;
            color: #f8fafc !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 8px rgba(139, 92, 246, 0.2) !important;
        }
        
        .modern-action-btn.danger {
            background: rgba(239, 68, 68, 0.1) !important;
            border-color: rgba(239, 68, 68, 0.3) !important;
            color: #fca5a5 !important;
        }
        
        .modern-action-btn.danger:hover {
            background: rgba(239, 68, 68, 0.2) !important;
            color: #f8fafc !important;
            box-shadow: 0 4px 8px rgba(239, 68, 68, 0.2) !important;
        }
        
        /* Checkbox personalizado */
        .modern-checkbox {
            width: 1rem !important;
            height: 1rem !important;
            border: 1px solid rgba(139, 92, 246, 0.3) !important;
            border-radius: 0.25rem !important;
            background: transparent !important;
            cursor: pointer !important;
        }
        
        .modern-checkbox:checked {
            background: #8B5CF6 !important;
            border-color: #8B5CF6 !important;
        }
        
        /* Acordeón de acciones masivas */
        .mass-actions-accordion {
            max-height: 0 !important;
            opacity: 0 !important;
            overflow: hidden !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            border-top: 1px solid rgba(42, 45, 71, 0.3) !important;
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.05) 0%, rgba(124, 58, 237, 0.05) 100%) !important;
        }
        
        .mass-actions-accordion.expanded {
            max-height: 60px !important;
            opacity: 1 !important;
        }
        
        .accordion-content {
            padding: 0.875rem 1.5rem !important;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
        }
        
        .selection-info {
            display: flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
            color: #f8fafc !important;
            font-weight: 600 !important;
            font-size: 0.875rem !important;
        }
        
        .selection-info i {
            color: #10b981 !important;
            font-size: 1rem !important;
        }
        
        .action-buttons {
            display: flex !important;
            gap: 0.75rem !important;
        }
        
        .action-btn {
            display: flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
            padding: 0.5rem 1rem !important;
            border-radius: 0.375rem !important;
            font-weight: 500 !important;
            font-size: 0.875rem !important;
            border: none !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
            text-decoration: none !important;
        }
        
        .action-btn.danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
            color: white !important;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3) !important;
        }
        
        .action-btn.danger:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%) !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4) !important;
        }
        
        .action-btn.secondary {
            background: rgba(107, 114, 128, 0.1) !important;
            border: 1px solid rgba(107, 114, 128, 0.3) !important;
            color: #9ca3af !important;
        }
        
        .action-btn.secondary:hover {
            background: rgba(107, 114, 128, 0.2) !important;
            border-color: rgba(107, 114, 128, 0.5) !important;
            color: #f3f4f6 !important;
            transform: translateY(-1px) !important;
        }
        
        /* Mantener estilos antiguos para los modales */
        .mass-action-btn {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
            border: none !important;
            color: white !important;
            padding: 0.5rem 1rem !important;
            border-radius: 0.375rem !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3) !important;
        }
        
        .mass-action-btn:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4) !important;
        }
        
        .mass-action-btn.secondary {
            background: rgba(139, 92, 246, 0.1) !important;
            border: 1px solid rgba(139, 92, 246, 0.3) !important;
            color: #c4b5fd !important;
            box-shadow: none !important;
        }
        
        .mass-action-btn.secondary:hover {
            background: rgba(139, 92, 246, 0.2) !important;
            color: #f8fafc !important;
        }
        
        /* Enlaces de ordenamiento en columnas */
        .column-sort-link {
            color: #94a3b8 !important;
            text-decoration: none !important;
            transition: color 0.2s ease !important;
            display: flex !important;
            align-items: center !important;
        }
        
        .column-sort-link:hover {
            color: #c4b5fd !important;
        }
        
        .column-sort-link i {
            font-size: 0.75rem !important;
            opacity: 0.8 !important;
        }
        
        /* Barra de filtros compacta integrada */
        .filter-toolbar {
            background: rgba(22, 33, 62, 0.3) !important;
            border-bottom: 1px solid rgba(42, 45, 71, 0.5) !important;
            padding: 1rem 1.5rem !important;
        }
        
        .filter-row {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            gap: 1rem !important;
        }
        
        .filter-group {
            display: flex !important;
            align-items: center !important;
            gap: 0.75rem !important;
            flex: 1 !important;
        }
        
        .filter-input {
            background: rgba(16, 23, 46, 0.8) !important;
            border: 1px solid rgba(139, 92, 246, 0.2) !important;
            border-radius: 0.375rem !important;
            color: #f8fafc !important;
            padding: 0.5rem 0.75rem !important;
            font-size: 0.875rem !important;
            width: 200px !important;
            transition: all 0.2s ease !important;
        }
        
        .filter-input:focus {
            outline: none !important;
            border-color: #8B5CF6 !important;
            box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.1) !important;
        }
        
        .filter-input::placeholder {
            color: #64748b !important;
        }
        
        .filter-select {
            background: rgba(16, 23, 46, 0.8) !important;
            border: 1px solid rgba(139, 92, 246, 0.2) !important;
            border-radius: 0.375rem !important;
            color: #f8fafc !important;
            padding: 0.5rem 0.75rem !important;
            font-size: 0.875rem !important;
            min-width: 140px !important;
            transition: all 0.2s ease !important;
        }
        
        .filter-select-sm {
            background: rgba(16, 23, 46, 0.8) !important;
            border: 1px solid rgba(139, 92, 246, 0.2) !important;
            border-radius: 0.375rem !important;
            color: #f8fafc !important;
            padding: 0.5rem !important;
            font-size: 0.875rem !important;
            width: 50px !important;
            text-align: center !important;
            transition: all 0.2s ease !important;
        }
        
        .filter-select:focus, .filter-select-sm:focus {
            outline: none !important;
            border-color: #8B5CF6 !important;
            box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.1) !important;
        }
        
        .filter-select option, .filter-select-sm option {
            background: #1a1a2e !important;
            color: #f8fafc !important;
        }
        
        .filter-actions {
            display: flex !important;
            align-items: center !important;
            gap: 0.75rem !important;
        }
        
        .filter-checkbox {
            display: flex !important;
            align-items: center !important;
            cursor: pointer !important;
            user-select: none !important;
        }
        
        .filter-checkbox input[type="checkbox"] {
            display: none !important;
        }
        
        .checkbox-custom {
            width: 1rem !important;
            height: 1rem !important;
            border: 1px solid rgba(139, 92, 246, 0.3) !important;
            border-radius: 0.25rem !important;
            background: transparent !important;
            margin-right: 0.5rem !important;
            transition: all 0.2s ease !important;
            position: relative !important;
            flex-shrink: 0 !important;
        }
        
        .filter-checkbox input[type="checkbox"]:checked + .checkbox-custom {
            background: #8B5CF6 !important;
            border-color: #8B5CF6 !important;
        }
        
        .filter-checkbox input[type="checkbox"]:checked + .checkbox-custom::after {
            content: '✓' !important;
            position: absolute !important;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            color: white !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
        }
        
        .checkbox-text {
            color: #cbd5e1 !important;
            font-size: 0.875rem !important;
            white-space: nowrap !important;
        }
        
        .filter-btn {
            background: rgba(139, 92, 246, 0.1) !important;
            border: 1px solid rgba(139, 92, 246, 0.3) !important;
            color: #c4b5fd !important;
            border-radius: 0.375rem !important;
            padding: 0.5rem !important;
            width: 2.25rem !important;
            height: 2.25rem !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            transition: all 0.2s ease !important;
            text-decoration: none !important;
            cursor: pointer !important;
        }
        
        .filter-btn:hover {
            background: rgba(139, 92, 246, 0.2) !important;
            color: #f8fafc !important;
            transform: translateY(-1px) !important;
        }
        
        .filter-btn.primary {
            background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%) !important;
            border-color: #8B5CF6 !important;
            color: white !important;
        }
        
        .filter-btn.primary:hover {
            background: linear-gradient(135deg, #7C3AED 0%, #6D28D9 100%) !important;
            color: white !important;
        }
        
        .filter-btn.secondary {
            background: rgba(107, 114, 128, 0.1) !important;
            border-color: rgba(107, 114, 128, 0.3) !important;
            color: #9ca3af !important;
        }
        
        .filter-btn.secondary:hover {
            background: rgba(107, 114, 128, 0.2) !important;
            color: #f3f4f6 !important;
        }
        
        .modern-btn-secondary {
            background: rgba(107, 114, 128, 0.1) !important;
            border: 1px solid rgba(107, 114, 128, 0.3) !important;
            color: #9ca3af !important;
            padding: 0.75rem 1.5rem !important;
            border-radius: 0.375rem !important;
            font-weight: 500 !important;
            transition: all 0.2s ease !important;
            text-decoration: none !important;
        }
        
        .modern-btn-secondary:hover {
            background: rgba(107, 114, 128, 0.2) !important;
            border-color: rgba(107, 114, 128, 0.5) !important;
            color: #f3f4f6 !important;
        }
        
        /* Navbar override - tema oscuro correcto */
        .navbar {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%) !important;
            border-bottom: 1px solid rgba(139, 92, 246, 0.3) !important;
        }
        
        .navbar-brand, .nav-link, .dropdown-item {
            color: #f8fafc !important;
        }
        
        .nav-link:hover, .dropdown-item:hover {
            color: #c4b5fd !important;
        }
        
        .dropdown-menu {
            background-color: #1a1a2e !important;
            border: 1px solid #2a2d47 !important;
        }
        
        /* Resaltar el menú activo */
        .navbar-nav .nav-link.active,
        .navbar-nav .nav-link[href*="productos"] {
            background: rgba(139, 92, 246, 0.2) !important;
            color: #f8fafc !important;
            border-radius: 0.375rem !important;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .modern-header {
                width: 98% !important;
                padding: 1.5rem 0.5rem !important;
                flex-direction: column !important;
                gap: 1rem !important;
                text-align: center !important;
            }
            
            .modern-table-card {
                width: 98% !important;
                margin: 0 auto !important;
                border-radius: 0 !important;
            }
            
            .filter-row {
                flex-direction: column !important;
                gap: 1rem !important;
            }
            
            .filter-group {
                flex-wrap: wrap !important;
            }
            
            .filter-input {
                width: 100% !important;
            }
            
            .filter-select {
                min-width: 120px !important;
            }
            
        }
    </style>
@endpush

@section('content')
<script>
document.body.classList.add('productos-modern');
</script>

<div class="py-4">
    <!-- Header moderno -->
    <div class="modern-header">
        <h1 class="modern-title">
            <i class="bi bi-box-seam"></i>Productos
        </h1>
        <a href="{{ route('productos.create') }}" class="modern-btn-primary">
            <i class="bi bi-plus me-2"></i>Nuevo Producto
        </a>
    </div>

    @if($productos->count() > 0)
        <!-- Tabla moderna con filtros integrados -->
        <div class="modern-table-card">
            <div class="table-header">
                <h6 class="table-title">
                    <i class="bi bi-box-seam me-2"></i>Lista de Productos
                </h6>
                <span class="table-meta">
                    Mostrando {{ $productos->firstItem() }}-{{ $productos->lastItem() }} de {{ $productos->total() }}
                </span>
            </div>
            
            <!-- Filtros compactos integrados -->
            <div class="filter-toolbar">
                <form method="GET" action="{{ route('productos.modern') }}" class="filter-row">
                    <div class="filter-group">
                        <input type="text" class="filter-input" name="search" 
                               value="{{ request('search') }}" placeholder="Buscar productos...">
                        <select class="filter-select" name="marca_producto">
                            <option value="todos" {{ request('marca_producto') === 'todos' ? 'selected' : '' }}>Todas las marcas</option>
                            <option value="bambu" {{ request('marca_producto') === 'bambu' ? 'selected' : '' }}>BAMBU</option>
                            <option value="saphirus" {{ request('marca_producto') === 'saphirus' ? 'selected' : '' }}>Saphirus</option>
                        </select>
                        <select class="filter-select" name="order_by">
                            <option value="nombre" {{ request('order_by') === 'nombre' ? 'selected' : '' }}>Ordenar por Nombre</option>
                            <option value="sku" {{ request('order_by') === 'sku' ? 'selected' : '' }}>Ordenar por SKU</option>
                            <option value="stock_actual" {{ request('order_by') === 'stock_actual' ? 'selected' : '' }}>Ordenar por Stock</option>
                            <option value="precio_base_l1" {{ request('order_by') === 'precio_base_l1' ? 'selected' : '' }}>Ordenar por Precio</option>
                        </select>
                        <select class="filter-select-sm" name="order_direction">
                            <option value="asc" {{ request('order_direction') === 'asc' ? 'selected' : '' }}>↑</option>
                            <option value="desc" {{ request('order_direction') === 'desc' ? 'selected' : '' }}>↓</option>
                        </select>
                    </div>
                    <div class="filter-actions">
                        <label class="filter-checkbox">
                            <input type="checkbox" name="stock_bajo" value="1" {{ request('stock_bajo') ? 'checked' : '' }}>
                            <span class="checkbox-custom"></span>
                            <span class="checkbox-text">Stock bajo</span>
                        </label>
                        <button type="submit" class="filter-btn primary">
                            <i class="bi bi-search"></i>
                        </button>
                        <a href="{{ route('productos.modern') }}" class="filter-btn secondary">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </form>
            </div>
            
            <!-- Acordeón de acciones masivas entre filtros y tabla -->
            <div class="mass-actions-accordion" id="massActionsAccordion">
                <div class="accordion-content">
                    <div class="selection-info">
                        <i class="bi bi-check-circle-fill"></i>
                        <span id="contadorSeleccionados">0 productos seleccionados</span>
                    </div>
                    <div class="action-buttons">
                        <button type="button" class="action-btn danger" onclick="eliminarSeleccionados()">
                            <i class="bi bi-trash"></i>
                            <span>Eliminar</span>
                        </button>
                        <button type="button" class="action-btn secondary" onclick="limpiarSeleccion()">
                            <i class="bi bi-x-circle"></i>
                            <span>Limpiar</span>
                        </button>
                    </div>
                </div>
            </div>

            <table class="modern-table">
                <thead>
                    <tr>
                        <th width="40">
                            <input type="checkbox" id="selectAll" class="modern-checkbox">
                        </th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['order_by' => 'nombre', 'order_direction' => request('order_by') === 'nombre' && request('order_direction') === 'asc' ? 'desc' : 'asc']) }}" 
                               class="column-sort-link">
                                PRODUCTO
                                @if(request('order_by') === 'nombre')
                                    <i class="bi bi-arrow-{{ request('order_direction') === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['order_by' => 'precio_base_l1', 'order_direction' => request('order_by') === 'precio_base_l1' && request('order_direction') === 'asc' ? 'desc' : 'asc']) }}" 
                               class="column-sort-link">
                                PRECIO L1
                                @if(request('order_by') === 'precio_base_l1')
                                    <i class="bi bi-arrow-{{ request('order_direction') === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['order_by' => 'stock_actual', 'order_direction' => request('order_by') === 'stock_actual' && request('order_direction') === 'asc' ? 'desc' : 'asc']) }}" 
                               class="column-sort-link">
                                STOCK
                                @if(request('order_by') === 'stock_actual')
                                    <i class="bi bi-arrow-{{ request('order_direction') === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['order_by' => 'marca_producto', 'order_direction' => request('order_by') === 'marca_producto' && request('order_direction') === 'asc' ? 'desc' : 'asc']) }}" 
                               class="column-sort-link">
                                MARCA
                                @if(request('order_by') === 'marca_producto')
                                    <i class="bi bi-arrow-{{ request('order_direction') === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                @endif
                            </a>
                        </th>
                        <th>TIPO</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $producto)
                        <tr>
                            <td>
                                <input type="checkbox" class="modern-checkbox producto-checkbox" 
                                       value="{{ $producto->id }}" name="productos_seleccionados[]">
                            </td>
                            <td>
                                <div class="product-info">
                                    <div class="product-avatar">
                                        {{ strtoupper(substr($producto->nombre, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="product-name">{{ $producto->nombre }}</div>
                                        <div class="product-sku">{{ $producto->sku }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="product-price">${{ number_format($producto->precio_base_l1, 2) }}</span>
                            </td>
                            <td>
                                @if($producto->stock_actual > 10)
                                    <span class="modern-stock-badge high">{{ $producto->stock_actual }}</span>
                                @elseif($producto->stock_actual > 0)
                                    <span class="modern-stock-badge low">{{ $producto->stock_actual }}</span>
                                @else
                                    <span class="modern-stock-badge out">Sin stock</span>
                                @endif
                            </td>
                            <td>
                                @if($producto->marca_producto === 'bambu')
                                    <span class="modern-brand-badge bambu">BAMBU</span>
                                @else
                                    <span class="modern-brand-badge saphirus">Saphirus</span>
                                @endif
                            </td>
                            <td>
                                @if($producto->es_combo)
                                    <span class="modern-type-badge combo">Combo</span>
                                @else
                                    <span class="modern-type-badge individual">Individual</span>
                                @endif
                            </td>
                            <td>
                                <div class="modern-action-group">
                                    <a href="{{ route('productos.show', $producto) }}" 
                                       class="modern-action-btn" title="Ver">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('productos.edit', $producto) }}" 
                                       class="modern-action-btn" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="modern-action-btn danger" title="Eliminar"
                                            onclick="confirmarEliminacion({{ $producto->id }}, '{{ $producto->nombre }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Paginación -->
        <div class="d-flex justify-content-center mt-4">
            {{ $productos->links() }}
        </div>

    @else
        <!-- Estado vacío -->
        <div class="modern-table-card">
            <div class="text-center py-5">
                <i class="bi bi-box-seam display-1" style="color: #8B5CF6; opacity: 0.6;"></i>
                <h3 style="color: #f8fafc; margin-top: 1rem;">No hay productos registrados</h3>
                <p style="color: #94a3b8; margin-bottom: 2rem;">Comienza agregando tu primer producto al inventario.</p>
                <a href="{{ route('productos.create') }}" class="modern-btn-primary">
                    <i class="bi bi-plus me-2"></i>Crear Producto
                </a>
            </div>
        </div>
    @endif
</div>

<!-- Modal de confirmación de eliminación individual -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="background: #1a1a2e; border: 1px solid rgba(139, 92, 246, 0.2);">
            <div class="modal-header" style="border-bottom: 1px solid rgba(42, 45, 71, 0.5);">
                <h5 class="modal-title" style="color: #f8fafc;">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter: invert(1);"></button>
            </div>
            <div class="modal-body" style="color: #cbd5e1;">
                <p>¿Estás seguro de que quieres eliminar el producto <strong id="productoNombre" style="color: #f8fafc;"></strong>?</p>
                <p class="text-danger"><small>Esta acción no se puede deshacer.</small></p>
            </div>
            <div class="modal-footer" style="border-top: 1px solid rgba(42, 45, 71, 0.5);">
                <button type="button" class="mass-action-btn secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="mass-action-btn">
                        <i class="bi bi-trash me-2"></i>Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación de eliminación masiva -->
<div class="modal fade" id="deleteMasivoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="background: #1a1a2e; border: 1px solid rgba(139, 92, 246, 0.2);">
            <div class="modal-header" style="border-bottom: 1px solid rgba(42, 45, 71, 0.5);">
                <h5 class="modal-title" style="color: #f8fafc;">Confirmar Eliminación Masiva</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter: invert(1);"></button>
            </div>
            <div class="modal-body" style="color: #cbd5e1;">
                <p>¿Estás seguro de que quieres eliminar <strong id="cantidadProductos" style="color: #f8fafc;"></strong> productos seleccionados?</p>
                <div class="alert alert-warning" style="background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.3); color: #fbbf24;">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Esta acción eliminará permanentemente los siguientes productos:
                </div>
                <ul id="listaProductosEliminar" class="list-unstyled" style="color: #cbd5e1;"></ul>
                <p class="text-danger"><small><strong>Esta acción no se puede deshacer.</strong></small></p>
            </div>
            <div class="modal-footer" style="border-top: 1px solid rgba(42, 45, 71, 0.5);">
                <button type="button" class="mass-action-btn secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteMasivoForm" method="POST" action="{{ route('productos.deleteMultiple') }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="productosIds" name="productos_ids">
                    <button type="submit" class="mass-action-btn">
                        <i class="bi bi-trash me-2"></i>Eliminar Todo
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Función original para eliminación individual
function confirmarEliminacion(id, nombre) {
    document.getElementById('productoNombre').textContent = nombre;
    document.getElementById('deleteForm').action = `/productos/${id}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

// Variables para manejo de selección masiva
let productosSeleccionados = new Set();
const productos = @json($productos->pluck('nombre', 'id'));

// Seleccionar/deseleccionar todos
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.producto-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
        if (this.checked) {
            productosSeleccionados.add(checkbox.value);
        } else {
            productosSeleccionados.delete(checkbox.value);
        }
    });
    actualizarInterfazSeleccion();
});

// Manejar selección individual
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('producto-checkbox')) {
        if (e.target.checked) {
            productosSeleccionados.add(e.target.value);
        } else {
            productosSeleccionados.delete(e.target.value);
            document.getElementById('selectAll').checked = false;
        }
        actualizarInterfazSeleccion();
    }
});

// Actualizar interfaz según selección con animación de acordeón
function actualizarInterfazSeleccion() {
    const cantidad = productosSeleccionados.size;
    const accordion = document.getElementById('massActionsAccordion');
    const contador = document.getElementById('contadorSeleccionados');
    
    if (cantidad > 0) {
        contador.textContent = `${cantidad} producto${cantidad > 1 ? 's' : ''} seleccionado${cantidad > 1 ? 's' : ''}`;
        
        // Expandir acordeón con animación suave
        accordion.classList.add('expanded');
    } else {
        // Contraer acordeón con animación suave
        accordion.classList.remove('expanded');
    }
    
    // Actualizar checkbox "Seleccionar todo"
    const totalCheckboxes = document.querySelectorAll('.producto-checkbox').length;
    const selectAllCheckbox = document.getElementById('selectAll');
    selectAllCheckbox.checked = cantidad === totalCheckboxes && cantidad > 0;
    selectAllCheckbox.indeterminate = cantidad > 0 && cantidad < totalCheckboxes;
}

// Limpiar selección
function limpiarSeleccion() {
    productosSeleccionados.clear();
    document.querySelectorAll('.producto-checkbox').forEach(checkbox => checkbox.checked = false);
    document.getElementById('selectAll').checked = false;
    actualizarInterfazSeleccion();
}

// Asegurar que el acordeón esté contraído al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    const accordion = document.getElementById('massActionsAccordion');
    if (accordion) {
        accordion.classList.remove('expanded');
    }
});

// Confirmar eliminación masiva
function eliminarSeleccionados() {
    if (productosSeleccionados.size === 0) return;
    
    const cantidadElement = document.getElementById('cantidadProductos');
    const listaElement = document.getElementById('listaProductosEliminar');
    const productosIdsInput = document.getElementById('productosIds');
    
    cantidadElement.textContent = productosSeleccionados.size;
    productosIdsInput.value = Array.from(productosSeleccionados).join(',');
    
    // Construir lista de productos
    listaElement.innerHTML = '';
    productosSeleccionados.forEach(id => {
        const li = document.createElement('li');
        li.innerHTML = `<i class="bi bi-arrow-right me-2"></i><strong>${productos[id]}</strong>`;
        li.className = 'mb-1';
        listaElement.appendChild(li);
    });
    
    new bootstrap.Modal(document.getElementById('deleteMasivoModal')).show();
}
</script>
@endsection