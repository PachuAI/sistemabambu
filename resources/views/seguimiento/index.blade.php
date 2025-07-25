@extends('layouts.app')

@section('title', 'Seguimiento de Entregas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-geo-alt"></i> Seguimiento de Entregas</h1>
    <div class="d-flex gap-2">
        <form method="GET" class="d-flex gap-2">
            <input type="date" 
                   name="fecha"
                   class="form-control" 
                   value="{{ $fechaSeleccionada }}">
            <select class="form-select" name="vehiculo_id">
                <option value="">Todos los vehículos</option>
                @foreach($vehiculos as $vehiculo)
                    <option value="{{ $vehiculo->id }}" {{ $vehiculoSeleccionado == $vehiculo->id ? 'selected' : '' }}>
                        {{ $vehiculo->nombre }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </form>
    </div>
</div>

<!-- Estadísticas -->
<div class="row mb-4">
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body p-3">
                <h4 class="text-primary">{{ $estadisticas['total'] }}</h4>
                <small class="text-muted">Total</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body p-3">
                <h4 class="text-secondary">{{ $estadisticas['planificados'] }}</h4>
                <small class="text-muted">Planificados</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body p-3">
                <h4 class="text-warning">{{ $estadisticas['en_ruta'] }}</h4>
                <small class="text-muted">En Ruta</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body p-3">
                <h4 class="text-success">{{ $estadisticas['entregados'] }}</h4>
                <small class="text-muted">Entregados</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body p-3">
                <h4 class="text-danger">{{ $estadisticas['no_entregados'] }}</h4>
                <small class="text-muted">No Entregados</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body p-3">
                @php
                    $porcentaje = $estadisticas['total'] > 0 ? round(($estadisticas['entregados'] / $estadisticas['total']) * 100) : 0;
                @endphp
                <h4 class="text-info">{{ $porcentaje }}%</h4>
                <small class="text-muted">Efectividad</small>
            </div>
        </div>
    </div>
</div>

<!-- Lista de repartos -->
<div class="card">
    <div class="card-body p-0">
        @forelse($repartos as $reparto)
            <div class="border-bottom p-3">
                <div class="row align-items-center">
                    <div class="col-md-1">
                        <span class="badge bg-secondary fs-6">{{ $reparto->orden_entrega }}</span>
                    </div>
                    <div class="col-md-2">
                        <strong>{{ $reparto->pedido->cliente->nombre }}</strong>
                        <br>
                        <small class="text-muted">#{{ $reparto->pedido->id }}</small>
                    </div>
                    <div class="col-md-2">
                        <i class="bi bi-geo-alt"></i> {{ $reparto->pedido->cliente->ciudad->nombre }}
                        <br>
                        <i class="bi bi-truck"></i> {{ $reparto->vehiculo->nombre }}
                    </div>
                    <div class="col-md-2">
                        <i class="bi bi-box"></i> {{ $reparto->bultos_asignados }} bultos
                        <br>
                        <i class="bi bi-currency-dollar"></i> ${{ number_format($reparto->pedido->monto_final, 0) }}
                    </div>
                    <div class="col-md-2">
                        @switch($reparto->estado)
                            @case('planificado')
                                <span class="badge bg-secondary">Planificado</span>
                                @break
                            @case('en_ruta')
                                <span class="badge bg-warning">En Ruta</span>
                                @break
                            @case('entregado')
                                <span class="badge bg-success">Entregado</span>
                                @break
                            @case('no_entregado')
                                <span class="badge bg-danger">No Entregado</span>
                                @break
                        @endswitch
                    </div>
                    <div class="col-md-3">
                        <div class="btn-group btn-group-sm">
                            @if($reparto->estado === 'planificado')
                                <form method="POST" action="{{ route('seguimiento.cambiar-estado', $reparto) }}" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="estado" value="en_ruta">
                                    <button type="submit" class="btn btn-warning" title="Marcar como en ruta">
                                        <i class="bi bi-truck"></i>
                                    </button>
                                </form>
                            @endif
                            
                            @if(in_array($reparto->estado, ['planificado', 'en_ruta']))
                                <form method="POST" action="{{ route('seguimiento.cambiar-estado', $reparto) }}" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="estado" value="entregado">
                                    <button type="submit" class="btn btn-success" title="Marcar como entregado">
                                        <i class="bi bi-check"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('seguimiento.cambiar-estado', $reparto) }}" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="estado" value="no_entregado">
                                    <button type="submit" class="btn btn-danger" title="Marcar como no entregado">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </form>
                            @endif
                            
                            @if(in_array($reparto->estado, ['entregado', 'no_entregado']))
                                <form method="POST" action="{{ route('seguimiento.cambiar-estado', $reparto) }}" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="estado" value="planificado">
                                    <button type="submit" class="btn btn-outline-secondary" title="Volver a planificado">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                
                @if($reparto->observaciones)
                    <div class="row mt-2">
                        <div class="col-12">
                            <small class="text-muted">
                                <i class="bi bi-chat-text"></i> {{ $reparto->observaciones }}
                            </small>
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="p-5 text-center text-muted">
                <i class="bi bi-truck display-1"></i>
                <h3>No hay repartos para la fecha seleccionada</h3>
                <p>Los repartos aparecerán aquí una vez que sean planificados.</p>
                <a href="{{ route('repartos.index') }}" class="btn btn-primary">
                    <i class="bi bi-calendar-plus"></i> Planificar Repartos
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection