@extends('layouts.app')

@section('title', 'Productos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-box-seam"></i> Productos</h1>
    <a href="{{ route('productos.create') }}" class="btn btn-success">
        <i class="bi bi-plus"></i> Nuevo Producto
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($productos->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre</th>
                            <th>SKU</th>
                            <th>Precio L1</th>
                            <th>Stock</th>
                            <th>Tipo</th>
                            <th width="150">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productos as $producto)
                            <tr>
                                <td>
                                    <strong>{{ $producto->nombre }}</strong>
                                </td>
                                <td>
                                    <code>{{ $producto->sku }}</code>
                                </td>
                                <td>
                                    <span class="text-success fw-bold">${{ number_format($producto->precio_base_l1, 2) }}</span>
                                </td>
                                <td>
                                    @if($producto->stock_actual > 0)
                                        <span class="badge bg-success">{{ $producto->stock_actual }}</span>
                                    @else
                                        <span class="badge bg-danger">Sin stock</span>
                                    @endif
                                </td>
                                <td>
                                    @if($producto->es_combo)
                                        <span class="badge bg-warning">Combo</span>
                                    @else
                                        <span class="badge bg-primary">Individual</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('productos.show', $producto) }}" 
                                           class="btn btn-outline-primary" title="Ver">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('productos.edit', $producto) }}" 
                                           class="btn btn-outline-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" title="Eliminar"
                                                onclick="confirmarEliminacion({{ $producto->id }}, '{{ $producto->nombre }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{ $productos->links() }}
        @else
            <div class="text-center py-5">
                <i class="bi bi-box-seam display-1 text-muted"></i>
                <h3 class="text-muted">No hay productos registrados</h3>
                <p class="text-muted">Comienza agregando tu primer producto.</p>
                <a href="{{ route('productos.create') }}" class="btn btn-success">
                    <i class="bi bi-plus"></i> Crear Producto
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
                <p>¿Estás seguro de que quieres eliminar el producto <strong id="productoNombre"></strong>?</p>
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
    document.getElementById('productoNombre').textContent = nombre;
    document.getElementById('deleteForm').action = `/productos/${id}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endsection