@extends('layouts.app')

@section('title', 'Editar Cliente: ' . $cliente->nombre)

@push('styles')
    <style>
        /* Aplicar tema moderno solo a esta página */
        body.cliente-edit-modern {
            background: linear-gradient(135deg, #0f0f23 0%, #16213e 100%) !important;
            color: #f8fafc !important;
            min-height: 100vh !important;
        }
        
        /* Container expandido */
        .container {
            max-width: 1400px !important;
            width: 95% !important;
        }
        
        /* Forzar width mínimo para formulario */
        .form-card {
            min-width: 700px !important;
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
        
        .client-avatar-medium {
            width: 3rem !important;
            height: 3rem !important;
            background: #8B5CF6 !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin-right: 1rem !important;
            font-weight: 600 !important;
            color: white !important;
            font-size: 1.125rem !important;
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
        
        /* Información adicional */
        .form-info {
            background: rgba(59, 130, 246, 0.1) !important;
            border: 1px solid rgba(59, 130, 246, 0.2) !important;
            border-radius: 0.375rem !important;
            padding: 1rem !important;
            margin-bottom: 1.5rem !important;
        }
        
        .form-info-title {
            color: #93c5fd !important;
            font-size: 0.875rem !important;
            font-weight: 600 !important;
            margin: 0 0 0.5rem 0 !important;
            display: flex !important;
            align-items: center !important;
        }
        
        .form-info-title i {
            margin-right: 0.5rem !important;
        }
        
        .form-info-text {
            color: #cbd5e1 !important;
            font-size: 0.75rem !important;
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
    document.body.classList.add('cliente-edit-modern');
</script>

<div class="modern-header">
    <div>
        <h1 class="modern-title">
            <i class="bi bi-person-gear"></i>Editar Cliente
        </h1>
        <div class="breadcrumb-modern">
            <a href="{{ route('clientes.index') }}">Clientes</a> / 
            <a href="{{ route('clientes.show.modern', $cliente) }}">{{ $cliente->nombre }}</a> / 
            <span>Editar</span>
        </div>
    </div>
</div>

<div class="form-card">
    <div class="form-header">
        <div class="client-avatar-medium">
            {{ substr($cliente->nombre, 0, 1) }}
        </div>
        <div>
            <div class="form-title">Editar información del cliente</div>
            <div class="form-subtitle">Actualiza los datos de {{ $cliente->nombre }}</div>
        </div>
    </div>
    
    <div class="form-body">
        <div class="form-info">
            <div class="form-info-title">
                <i class="bi bi-info-circle"></i>
                Información
            </div>
            <div class="form-info-text">
                Los campos marcados con asterisco (*) son obligatorios. Asegúrate de que los datos sean correctos antes de guardar.
            </div>
        </div>
        
        <form action="{{ route('clientes.update', $cliente) }}" method="POST" id="clienteForm">
            @csrf
            @method('PUT')
            
            <div class="form-grid">
                <div class="form-row">
                    <div class="form-group">
                        <label for="nombre" class="form-label-modern required">Nombre del Cliente</label>
                        <input type="text" 
                               class="form-input-modern @error('nombre') error @enderror" 
                               id="nombre" 
                               name="nombre" 
                               value="{{ old('nombre', $cliente->nombre) }}" 
                               placeholder="Ej: Carrefour Neuquén Centro"
                               required>
                        @error('nombre')
                            <div class="error-message">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="direccion" class="form-label-modern required">Dirección</label>
                        <input type="text" 
                               class="form-input-modern @error('direccion') error @enderror" 
                               id="direccion" 
                               name="direccion" 
                               value="{{ old('direccion', $cliente->direccion) }}" 
                               placeholder="Ej: Av. Argentina 2450"
                               required>
                        @error('direccion')
                            <div class="error-message">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="telefono" class="form-label-modern required">Teléfono</label>
                        <input type="text" 
                               class="form-input-modern @error('telefono') error @enderror" 
                               id="telefono" 
                               name="telefono" 
                               value="{{ old('telefono', $cliente->telefono) }}" 
                               placeholder="Ej: 299-442-8800"
                               required>
                        @error('telefono')
                            <div class="error-message">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
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
                                    {{ old('ciudad_id', $cliente->ciudad_id) == $ciudad->id ? 'selected' : '' }}>
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
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="email" class="form-label-modern">Email (opcional)</label>
                        <input type="email" 
                               class="form-input-modern @error('email') error @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $cliente->email) }}" 
                               placeholder="Ej: compras.neuquen@carrefour.com.ar">
                        @error('email')
                            <div class="error-message">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="form-actions">
                <a href="{{ route('clientes.show.modern', $cliente) }}" class="modern-btn-secondary">
                    <i class="bi bi-arrow-left"></i>Cancelar
                </a>
                <button type="submit" class="modern-btn-primary">
                    <i class="bi bi-save"></i>Actualizar Cliente
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Prevenir envío duplicado del formulario
    document.getElementById('clienteForm').addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Guardando...';
        
        // Re-habilitar después de 3 segundos por si hay error
        setTimeout(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-save me-2"></i>Actualizar Cliente';
        }, 3000);
    });
    
    // Auto-format teléfono (opcional)
    document.getElementById('telefono').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 6) {
            value = value.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
        }
        e.target.value = value;
    });
</script>
@endpush