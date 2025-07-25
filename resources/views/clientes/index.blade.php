@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-people"></i> Clientes</h1>
    <a href="{{ route('clientes.create') }}" class="btn btn-success">
        <i class="bi bi-plus"></i> Nuevo Cliente
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($clientes->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Ciudad</th>
                            <th width="150">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientes as $cliente)
                            <tr>
                                <td>
                                    <strong>{{ $cliente->nombre }}</strong>
                                </td>
                                <td>{{ $cliente->direccion }}</td>
                                <td>{{ $cliente->telefono }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $cliente->ciudad->nombre ?? 'Sin ciudad' }}</span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('clientes.show', $cliente) }}" 
                                           class="btn btn-outline-primary" title="Ver">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('clientes.edit', $cliente) }}" 
                                           class="btn btn-outline-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" title="Eliminar"
                                                onclick="confirmarEliminacion({{ $cliente->id }}, '{{ $cliente->nombre }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{ $clientes->links() }}
        @else
            <div class="text-center py-5">
                <i class="bi bi-people display-1 text-muted"></i>
                <h3 class="text-muted">No hay clientes registrados</h3>
                <p class="text-muted">Comienza agregando tu primer cliente.</p>
                <a href="{{ route('clientes.create') }}" class="btn btn-success">
                    <i class="bi bi-plus"></i> Crear Cliente
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
                <p>¿Estás seguro de que quieres eliminar el cliente <strong id="clienteNombre"></strong>?</p>
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
    document.getElementById('clienteNombre').textContent = nombre;
    document.getElementById('deleteForm').action = `/clientes/${id}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endsection