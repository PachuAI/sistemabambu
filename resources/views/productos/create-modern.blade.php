@extends('layouts.app')

@section('title', 'Nuevo Producto')

@push('styles')
    <style>
        /* Aplicar tema moderno solo a esta página */
        body.productos-create-modern {
            background: linear-gradient(135deg, #0f0f23 0%, #16213e 100%) !important;
            color: #f8fafc !important;
            min-height: 100vh !important;
        }

        /* Header con breadcrumb */
        .modern-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            max-width: 1400px;
            width: 100%;
            margin-left: auto;
            margin-right: auto;
            padding: 0 1rem;
        }

        .modern-title {
            color: #f8fafc !important;
            font-size: 2rem !important;
            font-weight: 700 !important;
            margin: 0 !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .modern-title i {
            color: #8B5CF6 !important;
        }

        .breadcrumb-modern {
            font-size: 0.875rem;
            color: #94a3b8;
        }

        /* Container principal */
        .modern-form-container {
            max-width: 1400px;
            width: 100%;
            margin: 0 auto;
            padding: 0 1rem;
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 2rem;
        }

        /* Card principal del formulario */
        .modern-form-card {
            background: rgba(26, 26, 46, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(139, 92, 246, 0.2);
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .form-section-title {
            color: #f8fafc;
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-section-title i {
            color: #8B5CF6;
        }

        /* Guía de campos */
        .guide-card {
            background: rgba(139, 92, 246, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(139, 92, 246, 0.3);
            border-radius: 1rem;
            padding: 1.5rem;
            height: fit-content;
            position: sticky;
            top: 2rem;
        }

        .guide-title {
            color: #8B5CF6;
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .guide-item {
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(139, 92, 246, 0.2);
        }

        .guide-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .guide-item-title {
            color: #f8fafc;
            font-weight: 500;
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .guide-item-title i {
            color: #8B5CF6;
            font-size: 0.875rem;
        }

        .guide-item-desc {
            color: #94a3b8;
            font-size: 0.875rem;
            line-height: 1.4;
        }

        /* Estilos de formulario */
        .modern-label {
            color: #cbd5e1 !important;
            font-size: 0.875rem !important;
            font-weight: 500 !important;
            margin-bottom: 0.5rem !important;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .modern-input,
        .modern-select,
        .modern-textarea {
            background: rgba(30, 41, 59, 0.5) !important;
            border: 1px solid rgba(139, 92, 246, 0.3) !important;
            color: #f8fafc !important;
            border-radius: 0.5rem !important;
            padding: 0.75rem 1rem !important;
            transition: all 0.3s ease !important;
            width: 100% !important;
        }

        .modern-input:focus,
        .modern-select:focus,
        .modern-textarea:focus {
            background: rgba(30, 41, 59, 0.8) !important;
            border-color: #8B5CF6 !important;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1) !important;
            outline: none !important;
        }

        .modern-input::placeholder {
            color: #64748b !important;
        }

        /* Input groups */
        .modern-input-group {
            position: relative;
            display: flex;
            align-items: stretch;
        }

        .modern-input-group-text {
            background: rgba(139, 92, 246, 0.2) !important;
            border: 1px solid rgba(139, 92, 246, 0.3) !important;
            color: #8B5CF6 !important;
            padding: 0.75rem 1rem !important;
            border-radius: 0.5rem 0 0 0.5rem !important;
            font-weight: 500;
        }

        .modern-input-group .modern-input {
            border-radius: 0 0.5rem 0.5rem 0 !important;
            border-left: none !important;
        }

        .modern-input-group-append .modern-input-group-text {
            border-radius: 0 0.5rem 0.5rem 0 !important;
            border-left: none !important;
        }

        .modern-input-group-append .modern-input {
            border-radius: 0.5rem 0 0 0.5rem !important;
            border-right: none !important;
        }

        /* Help text */
        .modern-help-text {
            color: #64748b !important;
            font-size: 0.75rem !important;
            margin-top: 0.25rem !important;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .modern-help-text i {
            color: #8B5CF6;
        }

        /* Botones */
        .btn-modern-cancel {
            background: rgba(100, 116, 139, 0.2) !important;
            border: 1px solid rgba(100, 116, 139, 0.3) !important;
            color: #cbd5e1 !important;
            padding: 0.75rem 1.5rem !important;
            border-radius: 0.5rem !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-modern-cancel:hover {
            background: rgba(100, 116, 139, 0.3) !important;
            border-color: rgba(100, 116, 139, 0.5) !important;
            color: #f8fafc !important;
            transform: translateY(-1px);
        }

        .btn-modern-primary {
            background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%) !important;
            border: none !important;
            color: white !important;
            padding: 0.75rem 1.5rem !important;
            border-radius: 0.5rem !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3) !important;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-modern-primary:hover {
            background: linear-gradient(135deg, #7C3AED 0%, #6D28D9 100%) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 20px rgba(139, 92, 246, 0.4) !important;
            color: white !important;
        }

        /* Botón Volver */
        .btn-modern-back {
            background: rgba(100, 116, 139, 0.1) !important;
            border: 1px solid rgba(100, 116, 139, 0.2) !important;
            color: #94a3b8 !important;
            padding: 0.5rem 1rem !important;
            border-radius: 0.5rem !important;
            font-size: 0.875rem !important;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-modern-back:hover {
            background: rgba(100, 116, 139, 0.2) !important;
            border-color: rgba(100, 116, 139, 0.3) !important;
            color: #cbd5e1 !important;
        }

        /* Errores de validación */
        .modern-input.is-invalid,
        .modern-select.is-invalid,
        .modern-textarea.is-invalid {
            border-color: #ef4444 !important;
        }

        .modern-invalid-feedback {
            color: #f87171 !important;
            font-size: 0.75rem !important;
            margin-top: 0.25rem !important;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .modern-form-container {
                grid-template-columns: 1fr;
            }

            .guide-card {
                position: static;
                margin-bottom: 2rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.body.classList.add('productos-create-modern');
        });
    </script>
@endpush

@section('content')
<div class="modern-header">
    <div>
        <h1 class="modern-title">
            <i class="bi bi-box-seam"></i> Crear Nuevo Producto
        </h1>
        <div class="breadcrumb-modern">Productos / Crear</div>
    </div>
    <a href="{{ route('productos.index') }}" class="btn-modern-back">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="modern-form-container">
    <div class="modern-form-card">
        <form action="{{ route('productos.store') }}" method="POST">
            @csrf
            
            <div class="form-section-title">
                <i class="bi bi-box"></i> Nuevo Producto
            </div>
            <p style="color: #94a3b8; margin-bottom: 2rem;">Completa la información básica del producto</p>
            
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="nombre" class="modern-label">Nombre del Producto *</label>
                    <input type="text" class="modern-input @error('nombre') is-invalid @enderror" 
                           id="nombre" name="nombre" value="{{ old('nombre') }}" 
                           placeholder="Ej: Desengrasante Industrial BAMBU 5L" required>
                    <div class="modern-help-text">
                        <i class="bi bi-info-circle"></i> Nombre descriptivo del producto
                    </div>
                    @error('nombre')
                        <div class="modern-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-4">
                    <label for="sku" class="modern-label">SKU (Código) *</label>
                    <input type="text" class="modern-input @error('sku') is-invalid @enderror" 
                           id="sku" name="sku" value="{{ old('sku') }}" 
                           placeholder="Ej: BAM-001" required>
                    <div class="modern-help-text">
                        <i class="bi bi-info-circle"></i> Código único del producto
                    </div>
                    @error('sku')
                        <div class="modern-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-4">
                    <label for="precio_base_l1" class="modern-label">Precio Base L1 *</label>
                    <div class="modern-input-group">
                        <span class="modern-input-group-text">$</span>
                        <input type="number" class="modern-input @error('precio_base_l1') is-invalid @enderror" 
                               id="precio_base_l1" name="precio_base_l1" 
                               value="{{ old('precio_base_l1') }}" 
                               placeholder="0.00"
                               step="0.01" min="0" required>
                    </div>
                    <div class="modern-help-text">
                        <i class="bi bi-info-circle"></i> Precio sin descuento
                    </div>
                    @error('precio_base_l1')
                        <div class="modern-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-4">
                    <label for="stock_actual" class="modern-label">Stock Actual *</label>
                    <input type="number" class="modern-input @error('stock_actual') is-invalid @enderror" 
                           id="stock_actual" name="stock_actual" 
                           value="{{ old('stock_actual', 0) }}" 
                           placeholder="0"
                           min="0" required>
                    <div class="modern-help-text">
                        <i class="bi bi-info-circle"></i> Unidades disponibles
                    </div>
                    @error('stock_actual')
                        <div class="modern-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-4">
                    <label for="peso_kg" class="modern-label">Peso (kg) *</label>
                    <div class="modern-input-group">
                        <input type="number" class="modern-input @error('peso_kg') is-invalid @enderror" 
                               id="peso_kg" name="peso_kg" 
                               value="{{ old('peso_kg', 5.000) }}" 
                               placeholder="5.000"
                               step="0.001" min="0" required>
                        <div class="modern-input-group-append">
                            <span class="modern-input-group-text">kg</span>
                        </div>
                    </div>
                    <div class="modern-help-text">
                        <i class="bi bi-info-circle"></i> 5kg = 1 bulto
                    </div>
                    @error('peso_kg')
                        <div class="modern-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="marca_producto" class="modern-label">Marca *</label>
                    <select class="modern-select @error('marca_producto') is-invalid @enderror" 
                            id="marca_producto" name="marca_producto" required>
                        <option value="bambu" {{ old('marca_producto') == 'bambu' ? 'selected' : '' }}>BAMBU</option>
                        <option value="saphirus" {{ old('marca_producto') == 'saphirus' ? 'selected' : '' }}>Saphirus</option>
                    </select>
                    <div class="modern-help-text">
                        <i class="bi bi-info-circle"></i> Marca del producto
                    </div>
                    @error('marca_producto')
                        <div class="modern-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-4">
                    <label for="es_combo" class="modern-label">Tipo de Producto *</label>
                    <select class="modern-select @error('es_combo') is-invalid @enderror" 
                            id="es_combo" name="es_combo" required>
                        <option value="0" {{ old('es_combo') == '0' ? 'selected' : '' }}>Individual</option>
                        <option value="1" {{ old('es_combo') == '1' ? 'selected' : '' }}>Combo (Sin descuento)</option>
                    </select>
                    <div class="modern-help-text">
                        <i class="bi bi-info-circle"></i> Los combos no aplican descuentos
                    </div>
                    @error('es_combo')
                        <div class="modern-invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-4">
                <label for="descripcion" class="modern-label">Descripción (opcional)</label>
                <textarea class="modern-textarea @error('descripcion') is-invalid @enderror" 
                          id="descripcion" name="descripcion" rows="3"
                          placeholder="Descripción detallada del producto...">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <div class="modern-invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-flex justify-content-between mt-5">
                <button type="button" class="btn-modern-cancel" onclick="window.location='{{ route('productos.index') }}'">
                    <i class="bi bi-x-lg"></i> Cancelar
                </button>
                <button type="submit" class="btn-modern-primary">
                    <i class="bi bi-check-lg"></i> Crear Producto
                </button>
            </div>
        </form>
    </div>

    <div class="guide-card">
        <h3 class="guide-title">
            <i class="bi bi-lightbulb"></i> Guía de Campos
        </h3>
        
        <div class="guide-item">
            <div class="guide-item-title">
                <i class="bi bi-tag"></i> Nombre del Producto
            </div>
            <div class="guide-item-desc">
                Nombre descriptivo que identifique claramente el producto
            </div>
        </div>

        <div class="guide-item">
            <div class="guide-item-title">
                <i class="bi bi-upc"></i> SKU
            </div>
            <div class="guide-item-desc">
                Código único del producto. Use prefijos como BAM- para BAMBU o SAP- para Saphirus
            </div>
        </div>

        <div class="guide-item">
            <div class="guide-item-title">
                <i class="bi bi-currency-dollar"></i> Precio Base
            </div>
            <div class="guide-item-desc">
                Precio sin descuento (L1). Los descuentos se calculan automáticamente según el volumen
            </div>
        </div>

        <div class="guide-item">
            <div class="guide-item-title">
                <i class="bi bi-box2"></i> Stock
            </div>
            <div class="guide-item-desc">
                Cantidad actual disponible. Se actualizará automáticamente con cada venta
            </div>
        </div>

        <div class="guide-item">
            <div class="guide-item-title">
                <i class="bi bi-speedometer2"></i> Peso
            </div>
            <div class="guide-item-desc">
                Peso del producto en kg. El sistema calcula automáticamente los bultos (5kg = 1 bulto)
            </div>
        </div>

        <div class="guide-item">
            <div class="guide-item-title">
                <i class="bi bi-collection"></i> Tipo
            </div>
            <div class="guide-item-desc">
                Los productos combo no aplican para descuentos por volumen
            </div>
        </div>
    </div>
</div>
@endsection