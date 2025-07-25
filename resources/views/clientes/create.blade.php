@extends('layouts.app')

@section('title', 'Crear Cliente')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-person-plus"></i> Crear Cliente</h1>
    <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('clientes.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre" class="form-label">Nombre/Referencia *</label>
                            <input type="text" 
                                   class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="{{ old('nombre') }}" 
                                   required 
                                   maxlength="100">
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="ciudad_id" class="form-label">Ciudad *</label>
                            <select class="form-select @error('ciudad_id') is-invalid @enderror" 
                                    id="ciudad_id" 
                                    name="ciudad_id" 
                                    required>
                                <option value="">Seleccionar ciudad...</option>
                                @foreach($ciudades as $ciudad)
                                    <option value="{{ $ciudad->id }}" 
                                            {{ old('ciudad_id') == $ciudad->id ? 'selected' : '' }}>
                                        {{ $ciudad->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ciudad_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección *</label>
                        <input type="text" 
                               class="form-control @error('direccion') is-invalid @enderror" 
                               id="direccion" 
                               name="direccion" 
                               value="{{ old('direccion') }}" 
                               required 
                               maxlength="255"
                               placeholder="Ej: Av. Corrientes 1234, CABA">
                        @error('direccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            La dirección debe ser única y se usará como identificador principal.
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="telefono" class="form-label">Teléfono *</label>
                        <input type="text" 
                               class="form-control @error('telefono') is-invalid @enderror" 
                               id="telefono" 
                               name="telefono" 
                               value="{{ old('telefono') }}" 
                               required 
                               maxlength="20"
                               placeholder="Ej: 011-4567-8901">
                        @error('telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check"></i> Crear Cliente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-info-circle"></i> Información</h5>
                <ul class="list-unstyled mb-0">
                    <li><strong>Nombre/Referencia:</strong> Alias o nombre del contacto para identificación rápida.</li>
                    <li><strong>Dirección:</strong> Identificador único del cliente en el sistema.</li>
                    <li><strong>Teléfono:</strong> Número de contacto principal.</li>
                    <li><strong>Ciudad:</strong> Ubicación geográfica para logística de repartos.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection