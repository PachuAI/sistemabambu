@extends('layouts.app')

@section('title', 'Crear Vehículo')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-truck"></i> Crear Vehículo</h1>
    <a href="{{ route('vehiculos.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('vehiculos.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del Vehículo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                               id="nombre" name="nombre" value="{{ old('nombre') }}" 
                               placeholder="Ej: Camión 1, Furgoneta A, etc." required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="capacidad_bultos" class="form-label">Capacidad en Bultos <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('capacidad_bultos') is-invalid @enderror" 
                               id="capacidad_bultos" name="capacidad_bultos" value="{{ old('capacidad_bultos') }}" 
                               min="1" placeholder="Ej: 50" required>
                        <div class="form-text">Número máximo de bultos que puede transportar este vehículo</div>
                        @error('capacidad_bultos')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="activo" name="activo" value="1" 
                                   {{ old('activo', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="activo">
                                Vehículo activo
                            </label>
                        </div>
                        <div class="form-text">Los vehículos inactivos no aparecerán en la planificación de rutas</div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('vehiculos.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check"></i> Crear Vehículo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection