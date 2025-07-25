@extends('layouts.app')

@section('title', 'Nuevo Producto')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">
            <i class="bi bi-box-seam"></i> Nuevo Producto
        </h5>
    </div>
    <div class="card-body">
        <form action="{{ route('productos.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombre" class="form-label">Nombre del Producto</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                           id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="sku" class="form-label">SKU (Código)</label>
                    <input type="text" class="form-control @error('sku') is-invalid @enderror" 
                           id="sku" name="sku" value="{{ old('sku') }}" required>
                    @error('sku')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="precio_base_l1" class="form-label">Precio Base L1</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control @error('precio_base_l1') is-invalid @enderror" 
                               id="precio_base_l1" name="precio_base_l1" 
                               value="{{ old('precio_base_l1') }}" 
                               step="0.01" min="0" required>
                    </div>
                    @error('precio_base_l1')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="stock_actual" class="form-label">Stock Actual</label>
                    <input type="number" class="form-control @error('stock_actual') is-invalid @enderror" 
                           id="stock_actual" name="stock_actual" 
                           value="{{ old('stock_actual', 0) }}" 
                           min="0" required>
                    @error('stock_actual')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="peso_kg" class="form-label">Peso (kg)</label>
                    <div class="input-group">
                        <input type="number" class="form-control @error('peso_kg') is-invalid @enderror" 
                               id="peso_kg" name="peso_kg" 
                               value="{{ old('peso_kg', 5.000) }}" 
                               step="0.001" min="0" required>
                        <span class="input-group-text">kg</span>
                    </div>
                    <small class="text-muted">5kg = 1 bulto</small>
                    @error('peso_kg')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="es_combo" class="form-label">Tipo de Producto</label>
                    <select class="form-select @error('es_combo') is-invalid @enderror" 
                            id="es_combo" name="es_combo" required>
                        <option value="0" {{ old('es_combo') == '0' ? 'selected' : '' }}>Producto Regular</option>
                        <option value="1" {{ old('es_combo') == '1' ? 'selected' : '' }}>Combo (Sin descuento)</option>
                    </select>
                    @error('es_combo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción (opcional)</label>
                <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                          id="descripcion" name="descripcion" rows="3">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Crear Producto
                </button>
            </div>
        </form>
    </div>
</div>
@endsection