@extends('layouts.app')

@section('title', 'Nueva Ciudad')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">
            <i class="bi bi-geo-alt"></i> Nueva Ciudad
        </h5>
    </div>
    <div class="card-body">
        <form action="{{ route('ciudades.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombre" class="form-label">Nombre de la Ciudad</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                           id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="provincia_id" class="form-label">Provincia</label>
                    <select class="form-select @error('provincia_id') is-invalid @enderror" 
                            id="provincia_id" name="provincia_id" required>
                        <option value="">Seleccionar provincia</option>
                        @foreach($provincias as $provincia)
                            <option value="{{ $provincia->id }}" {{ old('provincia_id') == $provincia->id ? 'selected' : '' }}>
                                {{ $provincia->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('provincia_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="codigo_postal" class="form-label">Código Postal</label>
                    <input type="text" class="form-control @error('codigo_postal') is-invalid @enderror" 
                           id="codigo_postal" name="codigo_postal" 
                           value="{{ old('codigo_postal') }}">
                    @error('codigo_postal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="latitud" class="form-label">Latitud (opcional)</label>
                    <input type="number" class="form-control @error('latitud') is-invalid @enderror" 
                           id="latitud" name="latitud" 
                           value="{{ old('latitud') }}" 
                           step="0.000001" min="-90" max="90">
                    @error('latitud')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="longitud" class="form-label">Longitud (opcional)</label>
                    <input type="number" class="form-control @error('longitud') is-invalid @enderror" 
                           id="longitud" name="longitud" 
                           value="{{ old('longitud') }}" 
                           step="0.000001" min="-180" max="180">
                    @error('longitud')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('ciudades.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-info text-white">
                    <i class="bi bi-save"></i> Crear Ciudad
                </button>
            </div>
        </form>
    </div>
</div>
@endsection