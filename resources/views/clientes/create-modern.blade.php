@extends('layouts.app')

@section('title', 'Crear Nuevo Cliente')

@push('styles')
    <style>
        /* Aplicar tema moderno solo a esta página */
        body.cliente-create-modern {
            background: linear-gradient(135deg, #0f0f23 0%, #16213e 100%) !important;
            color: #f8fafc !important;
            min-height: 100vh !important;
        }
        
        /* Container expandido */
        .container {
            max-width: 1400px !important;
            width: 95% !important;
        }
        
        /* Forzar width mínimo para evitar amontonamiento */
        .create-layout {
            min-width: 900px !important;
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
            font-size: 1.75rem !important;
            font-weight: 700 !important;
            margin: 0 !important;
        }
        
        .modern-title i {
            color: #8B5CF6 !important;
            margin-right: 0.75rem !important;
        }
        
        .breadcrumb-modern {
            color: #94a3b8 !important;
            font-size: 0.875rem !important;
        }
        
        .breadcrumb-modern a {
            color: #c4b5fd !important;
            text-decoration: none !important;
        }
        
        .breadcrumb-modern a:hover {
            color: #8B5CF6 !important;
        }
        
        /* Layout grid */
        .create-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }
        
        /* Card del formulario */
        .form-card {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%) !important;
            border: 1px solid rgba(139, 92, 246, 0.2) !important;
            border-radius: 0.5rem !important;
            overflow: hidden !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2) !important;
        }
        
        .form-header {
            background: linear-gradient(135deg, #16213e 0%, #1a1a2e 100%) !important;
            border-bottom: 1px solid rgba(42, 45, 71, 0.5) !important;
            padding: 1.5rem !important;
            display: flex !important;
            align-items: center !important;
        }
        
        .form-icon {
            width: 3rem !important;
            height: 3rem !important;
            background: #8B5CF6 !important;
            border-radius: 0.5rem !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin-right: 1rem !important;
            font-size: 1.25rem !important;
            color: white !important;
        }
        
        .form-title {
            color: #f8fafc !important;
            font-size: 1.25rem !important;
            font-weight: 600 !important;
            margin: 0 !important;
        }
        
        .form-subtitle {
            color: #94a3b8 !important;
            font-size: 0.875rem !important;
            margin: 0 !important;
        }
        
        .form-body {
            padding: 2rem !important;
        }
        
        /* Grid de campos */
        .form-grid {
            display: grid;
            gap: 1.5rem;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }
        
        /* Grupos de campos modernos */
        .form-group {
            position: relative;
        }
        
        .form-label-modern {
            color: #94a3b8 !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            margin-bottom: 0.5rem !important;
            display: block !important;
        }
        
        .form-label-modern.required:after {
            content: " *";
            color: #ef4444 !important;
        }
        
        .form-input-modern {
            width: 100% !important;
            background: rgba(139, 92, 246, 0.05) !important;
            border: 1px solid rgba(139, 92, 246, 0.2) !important;
            border-radius: 0.375rem !important;
            padding: 0.75rem 1rem !important;
            color: #f8fafc !important;
            font-size: 0.875rem !important;
            transition: all 0.2s ease !important;
        }
        
        .form-input-modern:focus {
            outline: none !important;
            background: rgba(139, 92, 246, 0.1) !important;
            border-color: #8B5CF6 !important;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1) !important;
        }
        
        .form-input-modern::placeholder {
            color: #64748b !important;
        }
        
        .form-select-modern {
            width: 100% !important;
            background: rgba(139, 92, 246, 0.05) !important;
            border: 1px solid rgba(139, 92, 246, 0.2) !important;
            border-radius: 0.375rem !important;
            padding: 0.75rem 1rem !important;
            color: #f8fafc !important;
            font-size: 0.875rem !important;
            transition: all 0.2s ease !important;
            cursor: pointer !important;
        }
        
        .form-select-modern:focus {
            outline: none !important;
            background: rgba(139, 92, 246, 0.1) !important;
            border-color: #8B5CF6 !important;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1) !important;
        }
        
        .form-select-modern option {
            background: #1a1a2e !important;
            color: #f8fafc !important;
        }
        
        /* Estados de error */
        .form-input-modern.error,
        .form-select-modern.error {
            border-color: #ef4444 !important;
            background: rgba(239, 68, 68, 0.05) !important;
        }
        
        .form-input-modern.error:focus,
        .form-select-modern.error:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
        }
        
        .error-message {
            color: #fca5a5 !important;
            font-size: 0.75rem !important;
            margin-top: 0.5rem !important;
            display: flex !important;
            align-items: center !important;
        }
        
        .error-message i {
            margin-right: 0.25rem !important;
        }
        
        .form-hint {
            color: #94a3b8 !important;
            font-size: 0.75rem !important;
            margin-top: 0.5rem !important;
            display: flex !important;
            align-items: center !important;
        }
        
        .form-hint i {
            margin-right: 0.25rem !important;
            color: #8B5CF6 !important;
        }
        
        /* Botones modernos */
        .form-actions {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(42, 45, 71, 0.5) !important;
        }
        
        .modern-btn-primary {
            background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%) !important;
            border: none !important;
            color: white !important;
            padding: 0.875rem 2rem !important;
            border-radius: 0.5rem !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3) !important;
            cursor: pointer !important;
            font-size: 0.875rem !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
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
            padding: 0.875rem 2rem !important;
            border-radius: 0.5rem !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
            cursor: pointer !important;
            font-size: 0.875rem !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        
        .modern-btn-secondary:hover {
            background: rgba(107, 114, 128, 0.2) !important;
            border-color: rgba(107, 114, 128, 0.5) !important;
            color: #f3f4f6 !important;
        }
        
        .modern-btn-secondary i,
        .modern-btn-primary i {
            margin-right: 0.5rem !important;
        }
        
        /* Card de información */
        .info-card {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%) !important;
            border: 1px solid rgba(139, 92, 246, 0.2) !important;
            border-radius: 0.5rem !important;
            overflow: hidden !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2) !important;
            height: fit-content !important;
        }
        
        .info-header {
            background: linear-gradient(135deg, #16213e 0%, #1a1a2e 100%) !important;
            border-bottom: 1px solid rgba(42, 45, 71, 0.5) !important;
            padding: 1.25rem 1.5rem !important;
        }
        
        .info-title {
            color: #f8fafc !important;
            font-size: 1.125rem !important;
            font-weight: 600 !important;
            margin: 0 !important;
            display: flex !important;
            align-items: center !important;
        }
        
        .info-title i {
            color: #8B5CF6 !important;
            margin-right: 0.75rem !important;
        }
        
        .info-body {
            padding: 1.5rem !important;
        }
        
        .info-list {
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        
        .info-item {
            display: flex !important;
            align-items: flex-start !important;
            padding: 0.75rem !important;
            margin-bottom: 0.75rem !important;
            background: rgba(139, 92, 246, 0.05) !important;
            border: 1px solid rgba(139, 92, 246, 0.1) !important;
            border-radius: 0.375rem !important;
            transition: all 0.2s ease !important;
        }
        
        .info-item:hover {
            background: rgba(139, 92, 246, 0.1) !important;
            border-color: rgba(139, 92, 246, 0.2) !important;
        }
        
        .info-item:last-child {
            margin-bottom: 0 !important;
        }
        
        .info-icon {
            color: #8B5CF6 !important;
            margin-right: 0.75rem !important;
            margin-top: 0.125rem !important;
            flex-shrink: 0 !important;
        }
        
        .info-content {
            flex: 1 !important;
        }
        
        .info-label {
            color: #f8fafc !important;
            font-weight: 600 !important;
            font-size: 0.875rem !important;
            margin-bottom: 0.25rem !important;
        }
        
        .info-text {
            color: #94a3b8 !important;
            font-size: 0.75rem !important;
            margin: 0 !important;
            line-height: 1.4 !important;
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
            
            .create-layout {
                grid-template-columns: 1fr !important;
                gap: 1rem !important;
            }
            
            .form-row {
                grid-template-columns: 1fr !important;
                gap: 1rem !important;
            }
            
            .form-actions {
                flex-direction: column-reverse !important;
            }
            
            .form-body {
                padding: 1.5rem !important;
            }
        }
    </style>
@endpush

@section('content')
<script>
    // Aplicar tema oscuro al cargar la página
    document.body.classList.add('cliente-create-modern');
</script>

<div class="modern-header">
    <div>
        <h1 class="modern-title">
            <i class="bi bi-person-plus"></i>Crear Nuevo Cliente
        </h1>
        <div class="breadcrumb-modern">
            <a href="{{ route('clientes.index') }}">Clientes</a> / 
            <span>Crear</span>
        </div>
    </div>
    <a href="{{ route('clientes.index') }}" class="modern-btn-secondary">
        <i class="bi bi-arrow-left"></i>Volver
    </a>
</div>

<div class="create-layout">
    <!-- Formulario principal -->
    <div class="form-card">
        <div class="form-header">
            <div class="form-icon">
                <i class="bi bi-person-vcard"></i>
            </div>
            <div>
                <div class="form-title">Nuevo Cliente</div>
                <div class="form-subtitle">Completa la información básica del cliente</div>
            </div>
        </div>
        
        <div class="form-body">
            <form action="{{ route('clientes.store') }}" method="POST" id="clienteCreateForm">
                @csrf
                
                <div class="form-grid">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nombre" class="form-label-modern required">Nombre/Referencia</label>
                            <input type="text" 
                                   class="form-input-modern @error('nombre') error @enderror" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="{{ old('nombre') }}" 
                                   placeholder="Ej: Carrefour Neuquén Centro"
                                   maxlength="100"
                                   required>
                            @error('nombre')
                                <div class="error-message">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="form-hint">
                                <i class="bi bi-info-circle"></i>
                                Alias o nombre del contacto para identificación rápida
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ciudad_id" class="form-label-modern required">Ciudad</label>
                            <select class="form-select-modern @error('ciudad_id') error @enderror" 
                                    id="ciudad_id" 
                                    name="ciudad_id" 
                                    required>
                                <option value="">Seleccionar ciudad...</option>
                                @foreach($ciudades as $ciudad)
                                    <option value="{{ $ciudad->id }}" 
                                        {{ old('ciudad_id') == $ciudad->id ? 'selected' : '' }}>
                                        {{ $ciudad->nombre }}, {{ $ciudad->provincia }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ciudad_id')
                                <div class="error-message">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="form-hint">
                                <i class="bi bi-geo-alt"></i>
                                Ubicación geográfica para logística de repartos
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="direccion" class="form-label-modern required">Dirección</label>
                        <input type="text" 
                               class="form-input-modern @error('direccion') error @enderror" 
                               id="direccion" 
                               name="direccion" 
                               value="{{ old('direccion') }}" 
                               placeholder="Ej: Av. Argentina 2450"
                               maxlength="255"
                               required>
                        @error('direccion')
                            <div class="error-message">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-hint">
                            <i class="bi bi-house"></i>
                            La dirección debe ser única y se usará como identificador principal
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="telefono" class="form-label-modern required">Teléfono</label>
                            <input type="text" 
                                   class="form-input-modern @error('telefono') error @enderror" 
                                   id="telefono" 
                                   name="telefono" 
                                   value="{{ old('telefono') }}" 
                                   placeholder="Ej: 299-442-8800"
                                   maxlength="20"
                                   required>
                            @error('telefono')
                                <div class="error-message">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="form-hint">
                                <i class="bi bi-telephone"></i>
                                Número de contacto principal
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label-modern">Email (opcional)</label>
                            <input type="email" 
                                   class="form-input-modern @error('email') error @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="Ej: compras.neuquen@carrefour.com.ar">
                            @error('email')
                                <div class="error-message">
                                    <i class="bi bi-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="form-hint">
                                <i class="bi bi-envelope"></i>
                                Email de contacto adicional
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <a href="{{ route('clientes.index') }}" class="modern-btn-secondary">
                        <i class="bi bi-x"></i>Cancelar
                    </a>
                    <button type="submit" class="modern-btn-primary">
                        <i class="bi bi-check"></i>Crear Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Card de información -->
    <div class="info-card">
        <div class="info-header">
            <h3 class="info-title">
                <i class="bi bi-lightbulb"></i>Guía de Campos
            </h3>
        </div>
        <div class="info-body">
            <ul class="info-list">
                <li class="info-item">
                    <i class="bi bi-person-badge info-icon"></i>
                    <div class="info-content">
                        <div class="info-label">Nombre/Referencia</div>
                        <div class="info-text">Alias o nombre del contacto para identificación rápida en el sistema</div>
                    </div>
                </li>
                
                <li class="info-item">
                    <i class="bi bi-house-door info-icon"></i>
                    <div class="info-content">
                        <div class="info-label">Dirección</div>
                        <div class="info-text">Identificador único del cliente. Debe ser específica y completa</div>
                    </div>
                </li>
                
                <li class="info-item">
                    <i class="bi bi-telephone info-icon"></i>
                    <div class="info-content">
                        <div class="info-label">Teléfono</div>
                        <div class="info-text">Número de contacto principal para comunicación directa</div>
                    </div>
                </li>
                
                <li class="info-item">
                    <i class="bi bi-geo-alt info-icon"></i>
                    <div class="info-content">
                        <div class="info-label">Ciudad</div>
                        <div class="info-text">Ubicación geográfica para planificación de rutas y repartos</div>
                    </div>
                </li>
                
                <li class="info-item">
                    <i class="bi bi-envelope info-icon"></i>
                    <div class="info-content">
                        <div class="info-label">Email</div>
                        <div class="info-text">Contacto adicional opcional para comunicaciones formales</div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Prevenir envío duplicado del formulario
    document.getElementById('clienteCreateForm').addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Creando...';
        
        // Re-habilitar después de 3 segundos por si hay error
        setTimeout(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-check me-2"></i>Crear Cliente';
        }, 3000);
    });
    
    // Auto-format teléfono
    document.getElementById('telefono').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 6) {
            value = value.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
        }
        e.target.value = value;
    });
    
    // Validación en tiempo real del nombre
    document.getElementById('nombre').addEventListener('input', function(e) {
        const value = e.target.value;
        const maxLength = 100;
        
        if (value.length > maxLength) {
            e.target.value = value.substring(0, maxLength);
        }
    });
    
    // Auto-focus en el primer campo
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('nombre').focus();
    });
</script>
@endpush