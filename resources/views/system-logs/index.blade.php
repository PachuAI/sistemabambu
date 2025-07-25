@extends('layouts.app')

@section('title', 'Logs del Sistema')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-journal-text"></i> Logs del Sistema</h1>
</div>

<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Registro de Actividades</h5>
    </div>
    <div class="card-body">
        <!-- Filtros -->
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <label for="modulo" class="form-label">Módulo</label>
                <select name="modulo" id="modulo" class="form-select">
                    <option value="">Todos los módulos</option>
                    <option value="productos" {{ request('modulo') == 'productos' ? 'selected' : '' }}>Productos</option>
                    <option value="clientes" {{ request('modulo') == 'clientes' ? 'selected' : '' }}>Clientes</option>
                    <option value="pedidos" {{ request('modulo') == 'pedidos' ? 'selected' : '' }}>Pedidos</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" name="fecha" id="fecha" class="form-control" value="{{ request('fecha') }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="bi bi-funnel"></i> Filtrar
                </button>
                <a href="{{ route('system-logs.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle"></i> Limpiar
                </a>
            </div>
        </form>

        @if($logs->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="140">Fecha/Hora</th>
                            <th width="100">Usuario</th>
                            <th width="80">Módulo</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                            <tr>
                                <td>
                                    <small>
                                        {{ $log->created_at->format('d/m/Y') }}<br>
                                        {{ $log->created_at->format('H:i:s') }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $log->usuario }}</span>
                                </td>
                                <td>
                                    @if($log->modulo)
                                        @php
                                            $badgeClass = match($log->modulo) {
                                                'productos' => 'bg-success',
                                                'clientes' => 'bg-primary',
                                                'pedidos' => 'bg-warning text-dark',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ ucfirst($log->modulo) }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $log->accion }}
                                    @if($log->data && count($log->data) > 0)
                                        <button class="btn btn-sm btn-outline-info ms-2" type="button" 
                                                data-bs-toggle="collapse" data-bs-target="#details-{{ $log->id }}">
                                            <i class="bi bi-info-circle"></i>
                                        </button>
                                        <div class="collapse mt-2" id="details-{{ $log->id }}">
                                            <div class="card card-body bg-light">
                                                <small>
                                                    @foreach($log->data as $key => $value)
                                                        <strong>{{ ucfirst($key) }}:</strong> {{ is_array($value) ? json_encode($value) : $value }}<br>
                                                    @endforeach
                                                </small>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{ $logs->withQueryString()->links() }}
        @else
            <div class="text-center py-4">
                <i class="bi bi-journal-text display-1 text-muted"></i>
                <h4 class="text-muted">No hay logs registrados</h4>
                <p class="text-muted">Los logs de actividades del sistema aparecerán aquí</p>
            </div>
        @endif
    </div>
</div>
@endsection