@extends('layouts.app')

@section('title', 'Planificación de Repartos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-truck"></i> Planificación de Repartos</h1>
    <div class="d-flex gap-2">
        <input type="date" 
               class="form-control" 
               id="fechaSelector"
               value="{{ $fechaSeleccionada }}"
               onchange="cambiarFecha(this.value)">
    </div>
</div>

<!-- Pestañas de días de la semana -->
<div class="mb-3">
    <div class="alert alert-info d-flex align-items-center">
        <i class="bi bi-info-circle me-2"></i>
        <div>
            <strong>Sistema de Planificación:</strong> 
            El calendario muestra la semana que contiene la fecha seleccionada. 
            Puedes navegar a cualquier fecha usando el selector de fecha o hacer clic en los días de la semana.
            <small class="d-block text-muted">Los repartos se organizan por día y se pueden planificar con anticipación.</small>
        </div>
    </div>
</div>

<ul class="nav nav-tabs mb-4" id="weekTabs" role="tablist">
    @php
        $fechaBase = \Carbon\Carbon::parse($fechaSeleccionada);
        $inicioSemana = $fechaBase->startOfWeek(\Carbon\Carbon::MONDAY);
        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
    @endphp
    
    @for($i = 0; $i < 7; $i++)
        @php
            $fecha = $inicioSemana->copy()->addDays($i);
            $isActive = $fecha->format('Y-m-d') === $fechaSeleccionada;
            $isToday = $fecha->isToday();
            $repartosCount = \App\Models\Reparto::where('fecha_reparto', $fecha->format('Y-m-d'))->count();
        @endphp
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $isActive ? 'active' : '' }} {{ $isToday ? 'fw-bold' : '' }}" 
                    onclick="cambiarFecha('{{ $fecha->format('Y-m-d') }}')"
                    type="button">
                {{ $diasSemana[$i] }}
                <br>
                <small class="text-muted">{{ $fecha->format('d/m') }}</small>
                @if($isToday)
                    <small class="badge bg-primary ms-1">Hoy</small>
                @endif
                @if($repartosCount > 0)
                    <small class="badge bg-success ms-1">{{ $repartosCount }}</small>
                @endif
            </button>
        </li>
    @endfor
</ul>

<div class="row">
    <!-- Panel izquierdo: Pedidos disponibles -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="bi bi-list-check"></i> 
                    Pedidos Disponibles ({{ $pedidosDisponibles->count() }})
                </h5>
            </div>
            <div class="card-body p-0" style="max-height: 600px; overflow-y: auto;">
                @forelse($pedidosDisponibles as $pedido)
                    <div class="border-bottom p-3" data-pedido-id="{{ $pedido->id }}">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <strong>{{ $pedido->cliente->nombre }}</strong>
                                    <small class="text-muted">#{{ $pedido->id }}</small>
                                </h6>
                                <div class="small text-muted mb-2">
                                    <i class="bi bi-geo-alt"></i> {{ $pedido->cliente->ciudad->nombre }}
                                    <br>
                                    <i class="bi bi-box"></i> {{ $pedido->bultos_totales }} bultos
                                    <br>
                                    <i class="bi bi-currency-dollar"></i> ${{ number_format($pedido->monto_final, 0) }}
                                </div>
                                <div class="small">
                                    {{ $pedido->items->count() }} productos
                                </div>
                            </div>
                            <button class="btn btn-sm btn-outline-success" 
                                    onclick="mostrarModalAsignar({{ $pedido->id }}, '{{ $pedido->cliente->nombre }}', {{ $pedido->bultos_totales }})">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-muted">
                        <i class="bi bi-inbox display-4"></i>
                        <p class="mt-2">No hay pedidos disponibles para asignar</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Panel central: Vehículos y asignaciones -->
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="bi bi-truck"></i> 
                    Vehículos y Asignaciones
                </h5>
            </div>
            <div class="card-body p-0">
                @foreach($vehiculos as $vehiculo)
                    @php
                        $repartosVehiculo = $repartosDelDia[$vehiculo->id] ?? collect();
                        $bultosUsados = $repartosVehiculo->sum('bultos_asignados');
                        $porcentajeUso = $vehiculo->capacidad_bultos > 0 ? round(($bultosUsados / $vehiculo->capacidad_bultos) * 100) : 0;
                        $colorBarra = $porcentajeUso < 70 ? 'bg-success' : ($porcentajeUso < 90 ? 'bg-warning' : 'bg-danger');
                    @endphp
                    
                    <div class="border-bottom p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0">
                                <i class="bi bi-truck"></i> {{ $vehiculo->nombre }}
                            </h6>
                            <small class="text-muted">
                                {{ $bultosUsados }}/{{ $vehiculo->capacidad_bultos }} bultos
                            </small>
                        </div>
                        
                        <!-- Barra de capacidad -->
                        <div class="progress mb-2" style="height: 8px;">
                            <div class="progress-bar {{ $colorBarra }}" 
                                 style="width: {{ $porcentajeUso }}%"></div>
                        </div>

                        <!-- Pedidos asignados -->
                        @if($repartosVehiculo->count() > 0)
                            <div class="small">
                                @foreach($repartosVehiculo as $reparto)
                                    <div class="d-flex justify-content-between align-items-center py-1">
                                        <div>
                                            <span class="badge bg-secondary me-1">{{ $reparto->orden_entrega }}</span>
                                            {{ $reparto->pedido->cliente->nombre }}
                                            <small class="text-muted">({{ $reparto->bultos_asignados }} bultos)</small>
                                        </div>
                                        <button class="btn btn-sm btn-outline-danger" 
                                                onclick="desasignarPedido({{ $reparto->id }})"
                                                title="Remover del reparto">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <small class="text-muted">Sin asignaciones</small>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Panel derecho: Resumen por ciudad -->
    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="bi bi-bar-chart"></i> 
                    Resumen por Ciudad
                </h5>
            </div>
            <div class="card-body p-0">
                @forelse($resumenCiudades as $resumen)
                    <div class="border-bottom p-3">
                        <h6 class="mb-1">{{ $resumen->ciudad }}</h6>
                        <div class="small text-muted">
                            <i class="bi bi-box"></i> {{ $resumen->total_bultos }} bultos
                            <br>
                            <i class="bi bi-people"></i> {{ $resumen->total_clientes }} clientes
                            <br>
                            <i class="bi bi-receipt"></i> {{ $resumen->total_pedidos }} pedidos
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-muted">
                        <i class="bi bi-graph-up display-4"></i>
                        <p class="mt-2">Sin repartos planificados</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Modal para asignar pedido -->
<div class="modal fade" id="asignarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Asignar Pedido al Reparto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('repartos.asignar') }}" method="POST" id="formAsignar">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="fecha_reparto" value="{{ $fechaSeleccionada }}">
                    <input type="hidden" name="pedido_id" id="modalPedidoId">
                    
                    <div class="mb-3">
                        <strong>Cliente:</strong> <span id="modalClienteNombre"></span><br>
                        <strong>Bultos:</strong> <span id="modalBultos"></span>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Vehículo</label>
                        <select name="vehiculo_id" class="form-select" required>
                            <option value="">Seleccionar vehículo...</option>
                            @foreach($vehiculos as $vehiculo)
                                @php
                                    $disponible = $vehiculo->bultosDisponibles($fechaSeleccionada);
                                @endphp
                                <option value="{{ $vehiculo->id }}" data-disponible="{{ $disponible }}">
                                    {{ $vehiculo->nombre }} ({{ $disponible }} bultos disponibles)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Orden de entrega</label>
                        <input type="number" name="orden_entrega" class="form-control" min="1" value="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnAsignar">Asignar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Formulario oculto para desasignar -->
<form id="desasignarForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@endsection

@section('scripts')
<script>
function cambiarFecha(fecha) {
    window.location.href = '{{ route("repartos.index") }}?fecha=' + fecha;
}

function mostrarModalAsignar(pedidoId, clienteNombre, bultos) {
    document.getElementById('modalPedidoId').value = pedidoId;
    document.getElementById('modalClienteNombre').textContent = clienteNombre;
    document.getElementById('modalBultos').textContent = bultos;
    
    // RESET: Limpiar estado anterior del select
    const select = document.querySelector('select[name="vehiculo_id"]');
    select.value = ''; // Limpiar selección
    
    // Restaurar todas las opciones a su estado original
    Array.from(select.options).forEach(option => {
        if (option.value) {
            option.disabled = false;
            // Limpiar texto previo
            const originalText = option.textContent.split(' (')[0];
            const disponible = parseInt(option.dataset.disponible);
            
            if (disponible < bultos) {
                option.disabled = true;
                option.textContent = `${originalText} (Sin capacidad suficiente)`;
            } else {
                option.textContent = `${originalText} (${disponible} bultos disponibles)`;
            }
        }
    });
    
    new bootstrap.Modal(document.getElementById('asignarModal')).show();
}

function desasignarPedido(repartoId) {
    if (confirm('¿Estás seguro de remover este pedido del reparto?')) {
        const form = document.getElementById('desasignarForm');
        form.action = '/repartos/' + repartoId + '/desasignar';
        form.submit();
    }
}

// Prevenir doble envío del formulario
document.getElementById('formAsignar').addEventListener('submit', function(e) {
    const btnAsignar = document.getElementById('btnAsignar');
    
    // Deshabilitar botón para prevenir doble clic
    btnAsignar.disabled = true;
    btnAsignar.innerHTML = '<i class="bi bi-hourglass-split"></i> Asignando...';
    
    // Reactivar el botón después de 3 segundos (por si hay error)
    setTimeout(() => {
        btnAsignar.disabled = false;
        btnAsignar.innerHTML = 'Asignar';
    }, 3000);
});

// Auto-refresh cada 5 minutos
setTimeout(() => {
    location.reload();
}, 300000);
</script>
@endsection