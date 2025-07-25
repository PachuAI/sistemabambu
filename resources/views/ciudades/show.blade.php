@extends('layouts.app')

@section('title', 'Ver Ciudad')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">
            <i class="bi bi-geo-alt"></i> Ver Ciudad
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Nombre de la Ciudad</label>
                <p class="form-control-plaintext">{{ $ciudad->nombre }}</p>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Provincia</label>
                <p class="form-control-plaintext">{{ $ciudad->provincia->nombre ?? 'N/A' }}</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Código Postal</label>
                <p class="form-control-plaintext">{{ $ciudad->codigo_postal ?? 'N/A' }}</p>
            </div>
            
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Latitud</label>
                <p class="form-control-plaintext">{{ $ciudad->latitud ?? 'N/A' }}</p>
            </div>
            
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Longitud</label>
                <p class="form-control-plaintext">{{ $ciudad->longitud ?? 'N/A' }}</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Fecha de Creación</label>
                <p class="form-control-plaintext">{{ $ciudad->created_at->format('d/m/Y H:i') }}</p>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Última Actualización</label>
                <p class="form-control-plaintext">{{ $ciudad->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
        
        <div class="d-flex justify-content-between">
            <a href="{{ route('ciudades.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
            <div>
                <a href="{{ route('ciudades.edit', $ciudad) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Editar
                </a>
                <form action="{{ route('ciudades.destroy', $ciudad) }}" method="POST" 
                      style="display: inline-block" 
                      onsubmit="return confirm('¿Está seguro de eliminar esta ciudad?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection