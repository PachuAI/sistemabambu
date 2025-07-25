@extends('layouts.app')

@section('title', 'Detalle del Vehículo')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-truck"></i> {{ $vehiculo->nombre }}</h1>
    <div class="btn-group">
        <a href="{{ route('vehiculos.edit', $vehiculo) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Editar
        </a>
        <a href="{{ route('vehiculos.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Información del Vehículo</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Nombre:</strong></td>
                        <td>{{ $vehiculo->nombre }}</td>
                    </tr>
                    <tr>
                        <td><strong>Capacidad:</strong></td>
                        <td><span class="badge bg-primary">{{ $vehiculo->capacidad_bultos }} bultos</span></td>
                    </tr>
                    <tr>
                        <td><strong>Estado:</strong></td>
                        <td>
                            @if($vehiculo->activo)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-secondary">Inactivo</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Creado:</strong></td>
                        <td>{{ $vehiculo->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Última modificación:</strong></td>
                        <td>{{ $vehiculo->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Estadísticas de Uso</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i>
                    Las estadísticas de uso se mostrarán aquí una vez que se implementen los repartos.
                </div>
                
                <div class="row text-center">
                    <div class="col-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h3 class="text-primary">0</h3>
                                <small class="text-muted">Repartos este mes</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h3 class="text-success">0</h3>
                                <small class="text-muted">Bultos transportados</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection