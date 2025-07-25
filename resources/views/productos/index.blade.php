@extends('layouts.app')

@section('title', 'Productos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-box-seam"></i> Productos</h1>
    <a href="{{ route('productos.create') }}" class="btn btn-success">
        <i class="bi bi-plus"></i> Nuevo Producto
    </a>
</div>

<!-- Filtros y búsqueda -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('productos.index') }}" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Buscar</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Nombre, SKU o descripción...">
            </div>
            <div class="col-md-2">
                <label for="marca_producto" class="form-label">Marca</label>
                <select class="form-select" id="marca_producto" name="marca_producto">
                    <option value="todos" {{ request('marca_producto') === 'todos' ? 'selected' : '' }}>Todas</option>
                    <option value="bambu" {{ request('marca_producto') === 'bambu' ? 'selected' : '' }}>BAMBU</option>
                    <option value="saphirus" {{ request('marca_producto') === 'saphirus' ? 'selected' : '' }}>Saphirus</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="order_by" class="form-label">Ordenar por</label>
                <select class="form-select" id="order_by" name="order_by">
                    <option value="nombre" {{ request('order_by') === 'nombre' ? 'selected' : '' }}>Nombre</option>
                    <option value="sku" {{ request('order_by') === 'sku' ? 'selected' : '' }}>SKU</option>
                    <option value="stock_actual" {{ request('order_by') === 'stock_actual' ? 'selected' : '' }}>Stock</option>
                    <option value="precio_base_l1" {{ request('order_by') === 'precio_base_l1' ? 'selected' : '' }}>Precio</option>
                    <option value="marca_producto" {{ request('order_by') === 'marca_producto' ? 'selected' : '' }}>Marca</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="order_direction" class="form-label">Dirección</label>
                <select class="form-select" id="order_direction" name="order_direction">
                    <option value="asc" {{ request('order_direction') === 'asc' ? 'selected' : '' }}>Ascendente</option>
                    <option value="desc" {{ request('order_direction') === 'desc' ? 'selected' : '' }}>Descendente</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                    <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                </div>
            </div>
            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="stock_bajo" name="stock_bajo" value="1" 
                           {{ request('stock_bajo') ? 'checked' : '' }}>
                    <label class="form-check-label" for="stock_bajo">
                        <i class="bi bi-exclamation-triangle text-warning"></i> Solo productos con stock bajo (menos de 10)
                    </label>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($productos->count() > 0)
            <!-- Acciones masivas -->
            <div class="mb-3" id="botonesAccionMasiva" style="display: none;">
                <div class="d-flex align-items-center gap-3 p-3 bg-light rounded">
                    <span id="contadorSeleccionados" class="fw-bold text-primary">0 productos seleccionados</span>
                    <div class="btn-group">
                        <button type="button" class="btn btn-danger btn-sm" onclick="eliminarSeleccionados()">
                            <i class="bi bi-trash"></i> Eliminar seleccionados
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="limpiarSeleccion()">
                            <i class="bi bi-x"></i> Limpiar selección
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="40">
                                <input type="checkbox" id="selectAll" class="form-check-input">
                            </th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['order_by' => 'nombre', 'order_direction' => request('order_by') === 'nombre' && request('order_direction') === 'asc' ? 'desc' : 'asc']) }}" 
                                   class="text-decoration-none text-dark">
                                    Nombre 
                                    @if(request('order_by') === 'nombre')
                                        <i class="bi bi-arrow-{{ request('order_direction') === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['order_by' => 'sku', 'order_direction' => request('order_by') === 'sku' && request('order_direction') === 'asc' ? 'desc' : 'asc']) }}" 
                                   class="text-decoration-none text-dark">
                                    SKU
                                    @if(request('order_by') === 'sku')
                                        <i class="bi bi-arrow-{{ request('order_direction') === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['order_by' => 'precio_base_l1', 'order_direction' => request('order_by') === 'precio_base_l1' && request('order_direction') === 'asc' ? 'desc' : 'asc']) }}" 
                                   class="text-decoration-none text-dark">
                                    Precio L1
                                    @if(request('order_by') === 'precio_base_l1')
                                        <i class="bi bi-arrow-{{ request('order_direction') === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['order_by' => 'stock_actual', 'order_direction' => request('order_by') === 'stock_actual' && request('order_direction') === 'asc' ? 'desc' : 'asc']) }}" 
                                   class="text-decoration-none text-dark">
                                    Stock
                                    @if(request('order_by') === 'stock_actual')
                                        <i class="bi bi-arrow-{{ request('order_direction') === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['order_by' => 'marca_producto', 'order_direction' => request('order_by') === 'marca_producto' && request('order_direction') === 'asc' ? 'desc' : 'asc']) }}" 
                                   class="text-decoration-none text-dark">
                                    Marca
                                    @if(request('order_by') === 'marca_producto')
                                        <i class="bi bi-arrow-{{ request('order_direction') === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th>Tipo</th>
                            <th width="150">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productos as $producto)
                            <tr>
                                <td>
                                    <input type="checkbox" class="form-check-input producto-checkbox" 
                                           value="{{ $producto->id }}" name="productos_seleccionados[]">
                                </td>
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
                                    @if($producto->stock_actual > 10)
                                        <span class="badge bg-success">{{ $producto->stock_actual }}</span>
                                    @elseif($producto->stock_actual > 0)
                                        <span class="badge bg-warning">{{ $producto->stock_actual }}</span>
                                    @else
                                        <span class="badge bg-danger">Sin stock</span>
                                    @endif
                                </td>
                                <td>
                                    @if($producto->marca_producto === 'bambu')
                                        <span class="badge bg-success">BAMBU</span>
                                    @else
                                        <span class="badge bg-info">Saphirus</span>
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

<!-- Modal de confirmación de eliminación individual -->
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

<!-- Modal de confirmación de eliminación masiva -->
<div class="modal fade" id="deleteMasivoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Eliminación Masiva</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que quieres eliminar <strong id="cantidadProductos"></strong> productos seleccionados?</p>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                    Esta acción eliminará permanentemente los siguientes productos:
                </div>
                <ul id="listaProductosEliminar" class="list-unstyled"></ul>
                <p class="text-danger"><small><strong>Esta acción no se puede deshacer.</strong></small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteMasivoForm" method="POST" action="{{ route('productos.deleteMultiple') }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="productosIds" name="productos_ids">
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Eliminar Todo
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Función original para eliminación individual
function confirmarEliminacion(id, nombre) {
    document.getElementById('productoNombre').textContent = nombre;
    document.getElementById('deleteForm').action = `/productos/${id}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

// Variables para manejo de selección masiva
let productosSeleccionados = new Set();
const productos = @json($productos->pluck('nombre', 'id'));

// Seleccionar/deseleccionar todos
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.producto-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
        if (this.checked) {
            productosSeleccionados.add(checkbox.value);
        } else {
            productosSeleccionados.delete(checkbox.value);
        }
    });
    actualizarInterfazSeleccion();
});

// Manejar selección individual
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('producto-checkbox')) {
        if (e.target.checked) {
            productosSeleccionados.add(e.target.value);
        } else {
            productosSeleccionados.delete(e.target.value);
            document.getElementById('selectAll').checked = false;
        }
        actualizarInterfazSeleccion();
    }
});

// Actualizar interfaz según selección
function actualizarInterfazSeleccion() {
    const cantidad = productosSeleccionados.size;
    const botonesAccion = document.getElementById('botonesAccionMasiva');
    const contador = document.getElementById('contadorSeleccionados');
    
    if (cantidad > 0) {
        botonesAccion.style.display = 'block';
        contador.textContent = `${cantidad} producto${cantidad > 1 ? 's' : ''} seleccionado${cantidad > 1 ? 's' : ''}`;
    } else {
        botonesAccion.style.display = 'none';
    }
    
    // Actualizar checkbox "Seleccionar todo"
    const totalCheckboxes = document.querySelectorAll('.producto-checkbox').length;
    const selectAllCheckbox = document.getElementById('selectAll');
    selectAllCheckbox.checked = cantidad === totalCheckboxes && cantidad > 0;
    selectAllCheckbox.indeterminate = cantidad > 0 && cantidad < totalCheckboxes;
}

// Limpiar selección
function limpiarSeleccion() {
    productosSeleccionados.clear();
    document.querySelectorAll('.producto-checkbox').forEach(checkbox => checkbox.checked = false);
    document.getElementById('selectAll').checked = false;
    actualizarInterfazSeleccion();
}

// Confirmar eliminación masiva
function eliminarSeleccionados() {
    if (productosSeleccionados.size === 0) return;
    
    const cantidadElement = document.getElementById('cantidadProductos');
    const listaElement = document.getElementById('listaProductosEliminar');
    const productosIdsInput = document.getElementById('productosIds');
    
    cantidadElement.textContent = productosSeleccionados.size;
    productosIdsInput.value = Array.from(productosSeleccionados).join(',');
    
    // Construir lista de productos
    listaElement.innerHTML = '';
    productosSeleccionados.forEach(id => {
        const li = document.createElement('li');
        li.innerHTML = `<i class="bi bi-arrow-right"></i> <strong>${productos[id]}</strong>`;
        li.className = 'mb-1';
        listaElement.appendChild(li);
    });
    
    new bootstrap.Modal(document.getElementById('deleteMasivoModal')).show();
}
</script>
@endsection