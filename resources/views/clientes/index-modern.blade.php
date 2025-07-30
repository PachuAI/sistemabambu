@extends('layouts.app')

@section('title', 'Clientes')

@push('styles')
    <style>
        /* Aplicar tema moderno solo a esta página */
        body.clientes-modern {
            background: linear-gradient(135deg, #0f0f23 0%, #16213e 100%) !important;
            color: #f8fafc !important;
            min-height: 100vh !important;
        }
        
        /* Container expandido */
        .container {
            max-width: 1400px !important;
            width: 95% !important;
        }
        
        /* Header moderno */
        .modern-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1.5rem 0;
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
        
        /* Cliente info con avatar */
        .client-info {
            display: flex !important;
            align-items: center !important;
        }
        
        .client-avatar {
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
        
        .client-name {
            color: #f8fafc !important;
            font-weight: 600 !important;
            margin-bottom: 0.125rem !important;
        }
        
        .client-since {
            color: #94a3b8 !important;
            font-size: 0.75rem !important;
        }
        
        /* Badge de ciudad moderna */
        .modern-city-badge {
            background: rgba(139, 92, 246, 0.2) !important;
            color: #c4b5fd !important;
            border: 1px solid rgba(139, 92, 246, 0.3) !important;
            padding: 0.25rem 0.75rem !important;
            border-radius: 0.375rem !important;
            font-size: 0.75rem !important;
            font-weight: 500 !important;
            display: inline-block !important;
        }
        
        .modern-city-badge.neuquen {
            background: rgba(16, 185, 129, 0.2) !important;
            color: #86efac !important;
            border-color: rgba(16, 185, 129, 0.3) !important;
        }
        
        .modern-city-badge.rio-negro {
            background: rgba(59, 130, 246, 0.2) !important;
            color: #93c5fd !important;
            border-color: rgba(59, 130, 246, 0.3) !important;
        }
        
        /* Etiquetas de clasificación de clientes */
        .client-label {
            padding: 0.25rem 0.75rem !important;
            border-radius: 0.375rem !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.025em !important;
            display: inline-block !important;
            border: 1px solid transparent !important;
            transition: all 0.2s ease !important;
        }
        
        .client-label.vip {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
            color: white !important;
            border-color: #f59e0b !important;
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3) !important;
        }
        
        .client-label.premium {
            background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%) !important;
            color: white !important;
            border-color: #8B5CF6 !important;
            box-shadow: 0 2px 8px rgba(139, 92, 246, 0.3) !important;
        }
        
        .client-label.regular {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            color: white !important;
            border-color: #10b981 !important;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3) !important;
        }
        
        .client-label.nuevo {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
            color: white !important;
            border-color: #3b82f6 !important;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3) !important;
        }
        
        .client-label.prospecto {
            background: rgba(107, 114, 128, 0.2) !important;
            color: #9ca3af !important;
            border-color: rgba(107, 114, 128, 0.3) !important;
        }
        
        .client-label.inactivo {
            background: rgba(239, 68, 68, 0.2) !important;
            color: #fca5a5 !important;
            border-color: rgba(239, 68, 68, 0.3) !important;
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
            font-size: 0.875rem !important;
            transition: all 0.2s ease !important;
            text-decoration: none !important;
            width: 2rem !important;
            height: 2rem !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        
        .modern-action-btn:hover {
            background: rgba(139, 92, 246, 0.2) !important;
            border-color: rgba(139, 92, 246, 0.5) !important;
            color: #f8fafc !important;
            transform: scale(1.1) !important;
        }
        
        .modern-action-btn.edit {
            background: rgba(245, 158, 11, 0.1) !important;
            border-color: rgba(245, 158, 11, 0.3) !important;
            color: #fbbf24 !important;
        }
        
        .modern-action-btn.edit:hover {
            background: rgba(245, 158, 11, 0.2) !important;
            border-color: rgba(245, 158, 11, 0.5) !important;
        }
        
        .modern-action-btn.delete {
            background: rgba(239, 68, 68, 0.1) !important;
            border-color: rgba(239, 68, 68, 0.3) !important;
            color: #fca5a5 !important;
        }
        
        .modern-action-btn.delete:hover {
            background: rgba(239, 68, 68, 0.2) !important;
            border-color: rgba(239, 68, 68, 0.5) !important;
        }
        
        /* Empty state moderno */
        .modern-empty-state {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%) !important;
            border: 1px solid rgba(139, 92, 246, 0.2) !important;
            border-radius: 0.5rem !important;
            padding: 4rem 2rem !important;
            text-align: center !important;
        }
        
        .modern-empty-icon {
            color: #94a3b8 !important;
            font-size: 4rem !important;
            margin-bottom: 1.5rem !important;
        }
        
        .modern-empty-title {
            color: #f8fafc !important;
            font-size: 1.5rem !important;
            font-weight: 600 !important;
            margin-bottom: 0.5rem !important;
        }
        
        .modern-empty-text {
            color: #94a3b8 !important;
            margin-bottom: 2rem !important;
        }
        
        /* Navbar override */
        .navbar {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%) !important;
            border-bottom: 1px solid #8B5CF6 !important;
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
        
        /* Paginación moderna */
        .pagination-wrapper {
            padding: 1.25rem 1.5rem !important;
            border-top: 1px solid rgba(42, 45, 71, 0.5) !important;
        }
        
        .pagination-container {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
        }
        
        .pagination-info {
            color: #94a3b8 !important;
            font-size: 0.875rem !important;
        }
        
        .pagination-controls {
            display: flex !important;
            gap: 0.5rem !important;
            align-items: center !important;
        }
        
        .pagination-btn {
            padding: 0.5rem 0.75rem !important;
            font-size: 0.875rem !important;
            color: #f8fafc !important;
            background: rgba(139, 92, 246, 0.1) !important;
            border: 1px solid rgba(139, 92, 246, 0.3) !important;
            border-radius: 0.375rem !important;
            text-decoration: none !important;
            transition: all 0.2s ease !important;
            min-width: 2.5rem !important;
            text-align: center !important;
        }
        
        .pagination-btn:hover {
            background: rgba(139, 92, 246, 0.2) !important;
            border-color: rgba(139, 92, 246, 0.5) !important;
            color: #f8fafc !important;
        }
        
        .pagination-btn.active {
            background: #8B5CF6 !important;
            border-color: #8B5CF6 !important;
            color: white !important;
        }
        
        .pagination-btn.disabled {
            background: rgba(107, 114, 128, 0.1) !important;
            border-color: rgba(107, 114, 128, 0.3) !important;
            color: #6b7280 !important;
            cursor: not-allowed !important;
        }
        
        /* Modal moderno */
        .modern-modal {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%) !important;
            border: 1px solid rgba(139, 92, 246, 0.2) !important;
            border-radius: 0.5rem !important;
        }
        
        .modern-modal-header {
            background: linear-gradient(135deg, #16213e 0%, #1a1a2e 100%) !important;
            border-bottom: 1px solid rgba(42, 45, 71, 0.5) !important;
            padding: 1.5rem !important;
            display: flex !important;
            align-items: center !important;
        }
        
        .modal-icon-wrapper {
            width: 3rem !important;
            height: 3rem !important;
            background: rgba(239, 68, 68, 0.2) !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin-right: 1rem !important;
        }
        
        .modal-warning-icon {
            color: #fca5a5 !important;
            font-size: 1.5rem !important;
        }
        
        .modern-modal-title {
            color: #f8fafc !important;
            font-weight: 600 !important;
            margin: 0 !important;
            flex: 1 !important;
        }
        
        .modern-btn-close {
            background: rgba(239, 68, 68, 0.1) !important;
            border: 1px solid rgba(239, 68, 68, 0.3) !important;
            color: #fca5a5 !important;
            border-radius: 0.375rem !important;
            padding: 0.5rem !important;
            width: 2rem !important;
            height: 2rem !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        
        .modern-btn-close:hover {
            background: rgba(239, 68, 68, 0.2) !important;
            border-color: rgba(239, 68, 68, 0.5) !important;
        }
        
        .modern-modal-body {
            padding: 1.5rem !important;
        }
        
        .modal-text {
            color: #cbd5e1 !important;
            margin-bottom: 0.5rem !important;
            font-size: 0.875rem !important;
        }
        
        .client-name-highlight {
            color: #f8fafc !important;
            font-weight: 600 !important;
        }
        
        .modal-warning {
            color: #fca5a5 !important;
            font-size: 0.75rem !important;
            margin: 0 !important;
        }
        
        .modern-modal-footer {
            background: linear-gradient(135deg, #16213e 0%, #1a1a2e 100%) !important;
            border-top: 1px solid rgba(42, 45, 71, 0.5) !important;
            padding: 1.5rem !important;
            display: flex !important;
            justify-content: flex-end !important;
            gap: 0.75rem !important;
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
        
        .modern-btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
            border: none !important;
            color: white !important;
            padding: 0.75rem 1.5rem !important;
            border-radius: 0.375rem !important;
            font-weight: 500 !important;
            transition: all 0.2s ease !important;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3) !important;
        }
        
        .modern-btn-danger:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%) !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4) !important;
            color: white !important;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .container {
                width: 98% !important;
            }
            
            .modern-header {
                flex-direction: column !important;
                gap: 1rem !important;
                text-align: center !important;
            }
            
            .table-header {
                flex-direction: column !important;
                gap: 0.5rem !important;
            }
            
            .pagination-container {
                flex-direction: column !important;
                gap: 1rem !important;
            }
            
            .pagination-controls {
                flex-wrap: wrap !important;
                justify-content: center !important;
            }
            
            .modern-modal-header {
                flex-direction: column !important;
                text-align: center !important;
                gap: 1rem !important;
            }
            
            .modern-modal-footer {
                flex-direction: column !important;
            }
        }
    </style>
@endpush

@section('content')
<script>
    // Aplicar tema oscuro al cargar la página
    document.body.classList.add('clientes-modern');
</script>

<div class="modern-header">
    <h1 class="modern-title">
        <i class="bi bi-people"></i>Clientes
    </h1>
    <a href="{{ route('clientes.create.modern') }}" class="modern-btn-primary">
        <i class="bi bi-plus me-2"></i>Nuevo Cliente
    </a>
</div>

@if($clientes->count() > 0)
    <!-- Tabla de clientes -->
    <div class="modern-table-card">
        <div class="table-header">
            <h3 class="table-title">Lista de Clientes</h3>
            <div class="table-meta">
                Mostrando {{ $clientes->firstItem() }}-{{ $clientes->lastItem() }} de {{ $clientes->total() }}
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Contacto</th>
                        <th>Dirección</th>
                        <th>Ciudad</th>
                        <th>Etiqueta</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach($clientes as $cliente)
                        <tr>
                            <td>
                                <div class="client-info">
                                    <div class="client-avatar">
                                        {{ substr($cliente->nombre, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="client-name">{{ $cliente->nombre }}</div>
                                        <div class="client-since">Cliente desde {{ $cliente->created_at->format('M Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <div style="color: #f8fafc; font-weight: 600;">{{ $cliente->telefono }}</div>
                                    <div style="color: #94a3b8; font-size: 0.75rem;">{{ $cliente->email ?? 'Sin email' }}</div>
                                </div>
                            </td>
                            <td>{{ $cliente->direccion }}</td>
                            <td>
                                @if($cliente->ciudad)
                                    @php
                                        $isNeuquen = str_contains($cliente->ciudad->provincia, 'Neuquén');
                                        $badgeClass = $isNeuquen ? 'neuquen' : 'rio-negro';
                                    @endphp
                                    <span class="modern-city-badge {{ $badgeClass }}">
                                        {{ $cliente->ciudad->nombre }}
                                    </span>
                                @else
                                    <span class="modern-city-badge">Sin ciudad</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    // Lógica de clasificación de clientes
                                    $totalPedidos = \DB::table('pedidos')->where('cliente_id', $cliente->id)->count();
                                    $totalFacturado = \DB::table('pedidos')->where('cliente_id', $cliente->id)->sum('monto_final') ?? 0;
                                    $ultimaActividad = \DB::table('pedidos')->where('cliente_id', $cliente->id)->latest('created_at')->first();
                                    
                                    // Clasificación por volumen y actividad
                                    if ($totalFacturado >= 500000) {
                                        $etiqueta = 'Cliente VIP';
                                        $etiquetaClass = 'vip';
                                    } elseif ($totalFacturado >= 200000) {
                                        $etiqueta = 'Cliente Premium';
                                        $etiquetaClass = 'premium';
                                    } elseif ($totalFacturado >= 50000) {
                                        $etiqueta = 'Cliente Regular';
                                        $etiquetaClass = 'regular';
                                    } elseif ($totalPedidos > 0) {
                                        $etiqueta = 'Cliente Nuevo';
                                        $etiquetaClass = 'nuevo';
                                    } else {
                                        $etiqueta = 'Prospecto';
                                        $etiquetaClass = 'prospecto';
                                    }
                                    
                                    // Si hace más de 3 meses sin pedidos, marcar como inactivo
                                    if ($ultimaActividad && \Carbon\Carbon::parse($ultimaActividad->created_at)->diffInMonths(now()) > 3) {
                                        $etiqueta = 'Inactivo';
                                        $etiquetaClass = 'inactivo';
                                    }
                                @endphp
                                <span class="client-label {{ $etiquetaClass }}">
                                    {{ $etiqueta }}
                                </span>
                            </td>
                            <td>
                                <div class="modern-action-group">
                                    <a href="{{ route('clientes.show.modern', $cliente) }}" 
                                       class="modern-action-btn" title="Ver">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('clientes.edit.modern', $cliente) }}" 
                                       class="modern-action-btn edit" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="modern-action-btn delete" title="Eliminar"
                                            onclick="confirmarEliminacion({{ $cliente->id }}, '{{ $cliente->nombre }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación moderna -->
            @if($clientes->hasPages())
                <div class="pagination-wrapper">
                    <div class="pagination-container">
                        <div class="pagination-info">
                            Mostrando {{ $clientes->firstItem() }} a {{ $clientes->lastItem() }} de {{ $clientes->total() }} clientes
                        </div>
                        <div class="pagination-controls">
                            @if($clientes->onFirstPage())
                                <span class="pagination-btn disabled">
                                    Anterior
                                </span>
                            @else
                                <a href="{{ $clientes->previousPageUrl() }}" class="pagination-btn">
                                    Anterior
                                </a>
                            @endif
                            
                            @foreach($clientes->getUrlRange(1, $clientes->lastPage()) as $page => $url)
                                @if($page == $clientes->currentPage())
                                    <span class="pagination-btn active">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="pagination-btn">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                            
                            @if($clientes->hasMorePages())
                                <a href="{{ $clientes->nextPageUrl() }}" class="pagination-btn">
                                    Siguiente
                                </a>
                            @else
                                <span class="pagination-btn disabled">
                                    Siguiente
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
@else
    <!-- Estado vacío moderno -->
    <div class="modern-empty-state">
        <div class="modern-empty-icon">
            <i class="bi bi-people"></i>
        </div>
        <h3 class="modern-empty-title">No hay clientes registrados</h3>
        <p class="modern-empty-text">Comienza agregando tu primer cliente para gestionar tu cartera comercial.</p>
        <a href="{{ route('clientes.create.modern') }}" class="modern-btn-primary">
            <i class="bi bi-plus me-2"></i>
            Crear Primer Cliente
        </a>
    </div>
@endif

<!-- Modal de confirmación moderno -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content modern-modal">
            <div class="modal-header modern-modal-header">
                <div class="modal-icon-wrapper">
                    <i class="bi bi-exclamation-triangle modal-warning-icon"></i>
                </div>
                <h5 class="modal-title modern-modal-title">Confirmar Eliminación</h5>
                <button type="button" class="btn-close modern-btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body modern-modal-body">
                <p class="modal-text">¿Estás seguro de que quieres eliminar el cliente <strong id="clienteNombre" class="client-name-highlight"></strong>?</p>
                <p class="modal-warning">Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer modern-modal-footer">
                <button type="button" class="modern-btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x me-2"></i>Cancelar
                </button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="modern-btn-danger">
                        <i class="bi bi-trash me-2"></i>Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Función para confirmar eliminación
    window.confirmarEliminacion = function(id, nombre) {
        document.getElementById('clienteNombre').textContent = nombre;
        document.getElementById('deleteForm').action = `/clientes/${id}`;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }
    
    // Filtro de tabla
    window.filterTable = function(searchTerm) {
        const table = document.getElementById('clientesTable');
        if (table) {
            const rows = table.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const searchData = row.getAttribute('data-search');
                if (searchData && searchData.includes(searchTerm.toLowerCase())) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    }
    
    // Toggle all checkboxes
    window.toggleAllCheckboxes = function(checked) {
        const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = checked;
        });
    }
</script>
@endpush