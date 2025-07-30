@extends('layouts.app')

@section('title', 'Cliente: ' . $cliente->nombre)

@push('styles')
    <style>
        /* Aplicar tema moderno solo a esta página */
        body.cliente-detail-modern {
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
            display: flex;
            align-items: center;
            color: #f8fafc !important;
            font-size: 2rem !important;
            font-weight: 700 !important;
            margin: 0 !important;
        }
        
        .client-avatar-large {
            width: 4rem !important;
            height: 4rem !important;
            background: #8B5CF6 !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin-right: 1rem !important;
            font-weight: 700 !important;
            color: white !important;
            font-size: 1.5rem !important;
        }
        
        .title-content h1 {
            color: #f8fafc !important;
            margin: 0 !important;
            font-size: 2rem !important;
            font-weight: 700 !important;
        }
        
        .title-content .client-since {
            color: #94a3b8 !important;
            font-size: 0.875rem !important;
            margin: 0 !important;
        }
        
        /* Botones modernos */
        .modern-btn-group {
            display: flex;
            gap: 0.75rem;
        }
        
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
        
        .modern-btn-secondary {
            background: rgba(107, 114, 128, 0.1) !important;
            border: 1px solid rgba(107, 114, 128, 0.3) !important;
            color: #9ca3af !important;
            padding: 0.75rem 1.5rem !important;
            border-radius: 0.5rem !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
        }
        
        .modern-btn-secondary:hover {
            background: rgba(107, 114, 128, 0.2) !important;
            border-color: rgba(107, 114, 128, 0.5) !important;
            color: #f3f4f6 !important;
        }
        
        /* Grid de cards */
        .cards-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        /* Card principal de información */
        .info-card {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%) !important;
            border: 1px solid rgba(139, 92, 246, 0.2) !important;
            border-radius: 0.5rem !important;
            overflow: hidden !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2) !important;
        }
        
        .card-header-modern {
            background: linear-gradient(135deg, #16213e 0%, #1a1a2e 100%) !important;
            border-bottom: 1px solid rgba(42, 45, 71, 0.5) !important;
            padding: 1.25rem 1.5rem !important;
        }
        
        .card-title-modern {
            color: #f8fafc !important;
            font-size: 1.125rem !important;
            font-weight: 600 !important;
            margin: 0 !important;
            display: flex !important;
            align-items: center !important;
        }
        
        .card-title-modern i {
            color: #8B5CF6 !important;
            margin-right: 0.75rem !important;
        }
        
        .card-body-modern {
            padding: 1.5rem !important;
        }
        
        /* Información del cliente en grid */
        .client-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        .info-item {
            display: flex;
            flex-direction: column;
            padding: 1rem;
            background: rgba(139, 92, 246, 0.05) !important;
            border: 1px solid rgba(139, 92, 246, 0.1) !important;
            border-radius: 0.375rem !important;
            transition: all 0.2s ease !important;
        }
        
        .info-item:hover {
            background: rgba(139, 92, 246, 0.1) !important;
            border-color: rgba(139, 92, 246, 0.2) !important;
        }
        
        .info-label {
            color: #94a3b8 !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            margin-bottom: 0.5rem !important;
        }
        
        .info-value {
            color: #f8fafc !important;
            font-size: 0.875rem !important;
            font-weight: 500 !important;
            word-break: break-word !important;
        }
        
        .info-value a {
            color: #c4b5fd !important;
            text-decoration: none !important;
            transition: color 0.2s ease !important;
        }
        
        .info-value a:hover {
            color: #8B5CF6 !important;
        }
        
        /* Badge de ciudad moderna */
        .modern-city-badge {
            background: rgba(139, 92, 246, 0.2) !important;
            color: #c4b5fd !important;
            border: 1px solid rgba(139, 92, 246, 0.3) !important;
            padding: 0.375rem 0.75rem !important;
            border-radius: 0.375rem !important;
            font-size: 0.75rem !important;
            font-weight: 500 !important;
            display: inline-block !important;
            width: fit-content !important;
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
        
        /* Cards de estadísticas */
        .stats-card {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%) !important;
            border: 1px solid rgba(139, 92, 246, 0.2) !important;
            border-radius: 0.5rem !important;
            overflow: hidden !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2) !important;
            height: fit-content !important;
        }
        
        .stats-grid {
            display: grid;
            gap: 1rem;
            padding: 1.5rem;
        }
        
        .stat-item {
            text-align: center;
            padding: 1.5rem 1rem;
            background: rgba(139, 92, 246, 0.05) !important;
            border: 1px solid rgba(139, 92, 246, 0.1) !important;
            border-radius: 0.375rem !important;
            transition: all 0.2s ease !important;
        }
        
        .stat-item:hover {
            background: rgba(139, 92, 246, 0.1) !important;
            border-color: rgba(139, 92, 246, 0.2) !important;
            transform: translateY(-2px) !important;
        }
        
        .stat-icon {
            width: 3rem !important;
            height: 3rem !important;
            border-radius: 0.5rem !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin: 0 auto 1rem auto !important;
            font-size: 1.25rem !important;
            color: white !important;
        }
        
        .stat-icon.primary { background: #8B5CF6 !important; }
        .stat-icon.success { background: #10b981 !important; }
        .stat-icon.warning { background: #f59e0b !important; }
        .stat-icon.danger { background: #ef4444 !important; }
        
        .stat-value {
            color: #f8fafc !important;
            font-size: 1.5rem !important;
            font-weight: 700 !important;
            margin: 0 0 0.25rem 0 !important;
        }
        
        .stat-label {
            color: #94a3b8 !important;
            font-size: 0.75rem !important;
            font-weight: 500 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            margin: 0 !important;
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
            
            .cards-grid {
                grid-template-columns: 1fr !important;
                gap: 1rem !important;
            }
            
            .client-info-grid {
                grid-template-columns: 1fr !important;
                gap: 1rem !important;
            }
            
            .modern-btn-group {
                flex-direction: column !important;
                width: 100% !important;
            }
            
            .modern-title {
                flex-direction: column !important;
                text-align: center !important;
                gap: 1rem !important;
            }
        }
    </style>
@endpush

@section('content')
<script>
    // Aplicar tema oscuro al cargar la página
    document.body.classList.add('cliente-detail-modern');
</script>

<div class="modern-header">
    <div class="modern-title">
        <div class="client-avatar-large">
            {{ substr($cliente->nombre, 0, 1) }}
        </div>
        <div class="title-content">
            <h1>{{ $cliente->nombre }}</h1>
            <p class="client-since">Cliente desde {{ $cliente->created_at->format('d/m/Y') }}</p>
        </div>
    </div>
    <div class="modern-btn-group">
        <a href="{{ route('clientes.edit.modern', $cliente) }}" class="modern-btn-primary">
            <i class="bi bi-pencil me-2"></i>Editar Cliente
        </a>
        <a href="{{ route('clientes.index') }}" class="modern-btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Volver
        </a>
    </div>
</div>

<div class="cards-grid">
    <!-- Card principal de información -->
    <div class="info-card">
        <div class="card-header-modern">
            <h3 class="card-title-modern">
                <i class="bi bi-person-vcard"></i>Información del Cliente
            </h3>
        </div>
        <div class="card-body-modern">
            <div class="client-info-grid">
                <div class="info-item">
                    <div class="info-label">Nombre/Referencia</div>
                    <div class="info-value">{{ $cliente->nombre }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Dirección</div>
                    <div class="info-value">{{ $cliente->direccion }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Teléfono</div>
                    <div class="info-value">
                        <a href="tel:{{ $cliente->telefono }}">{{ $cliente->telefono }}</a>
                    </div>
                </div>
                
                @if($cliente->email)
                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value">
                        <a href="mailto:{{ $cliente->email }}">{{ $cliente->email }}</a>
                    </div>
                </div>
                @endif
                
                <div class="info-item">
                    <div class="info-label">Ciudad</div>
                    <div class="info-value">
                        @if($cliente->ciudad)
                            @php
                                $isNeuquen = str_contains($cliente->ciudad->provincia, 'Neuquén');
                                $badgeClass = $isNeuquen ? 'neuquen' : 'rio-negro';
                            @endphp
                            <span class="modern-city-badge {{ $badgeClass }}">
                                {{ $cliente->ciudad->nombre }}, {{ $cliente->ciudad->provincia }}
                            </span>
                        @else
                            <span class="modern-city-badge">Sin ciudad asignada</span>
                        @endif
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Fecha de Registro</div>
                    <div class="info-value">{{ $cliente->created_at->format('d/m/Y H:i') }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Última Actualización</div>
                    <div class="info-value">{{ $cliente->updated_at->format('d/m/Y H:i') }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Última Actividad</div>
                    <div class="info-value">
                        @php
                            $ultimaActividad = \DB::table('pedidos')->where('cliente_id', $cliente->id)->latest('created_at')->first();
                        @endphp
                        @if($ultimaActividad)
                            {{ \Carbon\Carbon::parse($ultimaActividad->created_at)->diffForHumans() }}
                        @else
                            <span style="color: #94a3b8;">Sin actividad reciente</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Card de estadísticas -->
    <div class="stats-card">
        <div class="card-header-modern">
            <h3 class="card-title-modern">
                <i class="bi bi-graph-up"></i>Estadísticas
            </h3>
        </div>
        <div class="stats-grid">
            @php
                $totalPedidos = \DB::table('pedidos')->where('cliente_id', $cliente->id)->count();
                $totalFacturado = \DB::table('pedidos')->where('cliente_id', $cliente->id)->sum('monto_final');
                $pedidosEsteMes = \DB::table('pedidos')
                    ->where('cliente_id', $cliente->id)
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count();
            @endphp
            
            <div class="stat-item">
                <div class="stat-icon primary">
                    <i class="bi bi-cart"></i>
                </div>
                <div class="stat-value">{{ $totalPedidos }}</div>
                <div class="stat-label">Total Pedidos</div>
            </div>
            
            <div class="stat-item">
                <div class="stat-icon success">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="stat-value">${{ number_format($totalFacturado, 0, ',', '.') }}</div>
                <div class="stat-label">Total Facturado</div>
            </div>
            
            <div class="stat-item">
                <div class="stat-icon warning">
                    <i class="bi bi-calendar-month"></i>
                </div>
                <div class="stat-value">{{ $pedidosEsteMes }}</div>
                <div class="stat-label">Este Mes</div>
            </div>
            
            <div class="stat-item">
                <div class="stat-icon {{ $ultimaActividad ? 'success' : 'danger' }}">
                    <i class="bi bi-activity"></i>
                </div>
                <div class="stat-value">{{ $ultimaActividad ? 'Activo' : 'Inactivo' }}</div>
                <div class="stat-label">Estado</div>
            </div>
        </div>
    </div>
</div>
@endsection