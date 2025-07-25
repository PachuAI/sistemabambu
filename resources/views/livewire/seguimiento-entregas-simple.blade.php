<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-geo-alt"></i> Seguimiento de Entregas</h1>
        <div class="d-flex gap-2">
            <input type="date" 
                   class="form-control" 
                   wire:model.live="fechaSeleccionada">
            <select class="form-select" wire:model.live="vehiculoSeleccionado">
                <option value="">Todos los vehículos</option>
                @foreach($vehiculos as $vehiculo)
                    <option value="{{ $vehiculo->id }}">{{ $vehiculo->nombre }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="card text-center">
                <div class="card-body p-3">
                    <h4 class="text-primary">{{ count($repartos) }}</h4>
                    <small class="text-muted">Total</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center">
                <div class="card-body p-3">
                    <h4 class="text-secondary">{{ $repartos->where('estado', 'planificado')->count() }}</h4>
                    <small class="text-muted">Planificados</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center">
                <div class="card-body p-3">
                    <h4 class="text-warning">{{ $repartos->where('estado', 'en_ruta')->count() }}</h4>
                    <small class="text-muted">En Ruta</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center">
                <div class="card-body p-3">
                    <h4 class="text-success">{{ $repartos->where('estado', 'entregado')->count() }}</h4>
                    <small class="text-muted">Entregados</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center">
                <div class="card-body p-3">
                    <h4 class="text-danger">{{ $repartos->where('estado', 'no_entregado')->count() }}</h4>
                    <small class="text-muted">No Entregados</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center">
                <div class="card-body p-3">
                    @php
                        $total = count($repartos);
                        $entregados = $repartos->where('estado', 'entregado')->count();
                        $porcentaje = $total > 0 ? round(($entregados / $total) * 100) : 0;
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
                            <strong>{{ $reparto->pedido->cliente->nombre ?? 'Cliente eliminado' }}</strong>
                            <br>
                            <small class="text-muted">#{{ $reparto->pedido->id }}</small>
                        </div>
                        <div class="col-md-2">
                            <i class="bi bi-geo-alt"></i> {{ $reparto->pedido->cliente->ciudad->nombre ?? 'N/A' }}
                            <br>
                            <i class="bi bi-truck"></i> {{ $reparto->vehiculo->nombre ?? 'Vehículo eliminado' }}
                        </div>
                        <div class="col-md-2">
                            <i class="bi bi-box"></i> {{ $reparto->bultos_asignados }} bultos
                            <br>
                            <i class="bi bi-currency-dollar"></i> ${{ number_format($reparto->pedido->monto_final ?? 0, 0) }}
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
                                    <button class="btn btn-warning" 
                                            wire:click="cambiarEstado({{ $reparto->id }}, 'en_ruta')"
                                            title="Marcar como en ruta">
                                        <i class="bi bi-truck"></i>
                                    </button>
                                @endif
                                
                                @if(in_array($reparto->estado, ['planificado', 'en_ruta']))
                                    <button class="btn btn-success" 
                                            wire:click="cambiarEstado({{ $reparto->id }}, 'entregado')"
                                            title="Marcar como entregado">
                                        <i class="bi bi-check"></i>
                                    </button>
                                    <button class="btn btn-danger" 
                                            wire:click="cambiarEstado({{ $reparto->id }}, 'no_entregado')"
                                            title="Marcar como no entregado">
                                        <i class="bi bi-x"></i>
                                    </button>
                                @endif
                                
                                @if(in_array($reparto->estado, ['entregado', 'no_entregado']))
                                    <button class="btn btn-outline-secondary" 
                                            wire:click="cambiarEstado({{ $reparto->id }}, 'planificado')"
                                            title="Volver a planificado">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
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
</div>