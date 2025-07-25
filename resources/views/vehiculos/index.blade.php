@extends('layouts.app')

@section('title', 'Vehículos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-truck"></i> Vehículos</h1>
    <a href="{{ route('vehiculos.create') }}" class="btn btn-success">
        <i class="bi bi-plus"></i> Nuevo Vehículo
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($vehiculos->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Capacidad (Bultos)</th>
                            <th>Estado</th>
                            <th width="150">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vehiculos as $vehiculo)
                            <tr>
                                <td>
                                    <strong>{{ $vehiculo->nombre }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $vehiculo->capacidad_bultos }} bultos</span>
                                </td>
                                <td>
                                    @if($vehiculo->activo)
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-secondary">Inactivo</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('vehiculos.show', $vehiculo) }}" 
                                           class="btn btn-outline-primary" title="Ver">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('vehiculos.edit', $vehiculo) }}" 
                                           class="btn btn-outline-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" title="Eliminar"
                                                onclick="confirmarEliminacion({{ $vehiculo->id }}, '{{ $vehiculo->nombre }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-truck display-1 text-muted"></i>
                <h3 class="text-muted">No hay vehículos registrados</h3>
                <p class="text-muted">Comienza agregando tu primer vehículo.</p>
                <a href="{{ route('vehiculos.create') }}" class="btn btn-success">
                    <i class="bi bi-plus"></i> Crear Vehículo
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Modal de confirmación de eliminación -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que quieres eliminar el vehículo <strong id="vehiculoNombre"></strong>?</p>
                <p class="text-danger"><small>Esta acción no se puede deshacer.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
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

@section('scripts')
<script>
function confirmarEliminacion(id, nombre) {
    document.getElementById('vehiculoNombre').textContent = nombre;
    document.getElementById('deleteForm').action = `/vehiculos/${id}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endsection