@extends('layouts.app')

@section('title', 'Pedido #' . $pedido->id)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-receipt"></i> Pedido #{{ $pedido->id }}</h1>
    <div>
        @if($pedido->estado === 'confirmado')
            <button class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editPedidoModal">
                <i class="bi bi-pencil"></i> Editar Pedido
            </button>
        @endif
        <a href="{{ route('pedidos.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver al Listado
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Información del Cliente -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-person"></i> Cliente</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>{{ $pedido->cliente->nombre }}</strong><br>
                        <small class="text-muted">{{ $pedido->cliente->direccion }}</small><br>
                        <small class="text-muted">{{ $pedido->cliente->telefono }}</small>
                    </div>
                    <div class="col-md-6">
                        <span class="badge bg-info">{{ $pedido->cliente->ciudad->nombre }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Items del Pedido -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-box-seam"></i> Productos</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Producto</th>
                                <th>SKU</th>
                                <th>Cantidad</th>
                                <th>Precio Unit.</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pedido->items as $item)
                                <tr>
                                    <td>
                                        @if($item->producto)
                                            <strong>{{ $item->producto->nombre }}</strong>
                                            @if($item->producto->es_combo)
                                                <span class="badge bg-warning text-dark ms-1">Combo</span>
                                            @endif
                                        @else
                                            <strong class="text-muted">Producto eliminado</strong>
                                            <span class="badge bg-secondary ms-1">No disponible</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->producto)
                                            <code>{{ $item->producto->sku }}</code>
                                        @else
                                            <code class="text-muted">N/A</code>
                                        @endif
                                    </td>
                                    <td>{{ $item->cantidad }}</td>
                                    <td>${{ number_format($item->precio_unit_l1, 2) }}</td>
                                    <td><strong>${{ number_format($item->subtotal, 2) }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Resumen del Pedido -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-calculator"></i> Resumen</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th>Subtotal:</th>
                        <td class="text-end">${{ number_format($pedido->monto_bruto, 2) }}</td>
                    </tr>
                    @if($pedido->nivelDescuento)
                    <tr>
                        <th>Descuento {{ $pedido->nivelDescuento->nombre }}:</th>
                        <td class="text-end text-success">-${{ number_format($pedido->monto_bruto - $pedido->monto_final, 2) }}</td>
                    </tr>
                    @endif
                    <tr class="table-primary">
                        <th><strong>TOTAL:</strong></th>
                        <td class="text-end"><strong>${{ number_format($pedido->monto_final, 2) }}</strong></td>
                    </tr>
                    <tr class="table-info">
                        <th><strong>BULTOS:</strong></th>
                        <td class="text-end"><strong>{{ $pedido->bultos_totales }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Estado del Pedido -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Estado</h5>
            </div>
            <div class="card-body">
                @php
                    $badgeClass = match($pedido->estado) {
                        'confirmado' => 'bg-success',
                        'en_reparto' => 'bg-primary',
                        'entregado' => 'bg-secondary',
                        'cancelado' => 'bg-danger',
                        default => 'bg-warning'
                    };
                @endphp
                <div class="text-center">
                    <span class="badge {{ $badgeClass }} fs-6 p-3">{{ ucfirst($pedido->estado) }}</span>
                </div>
                <hr>
                <small class="text-muted">
                    <strong>Creado:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}<br>
                    <strong>Actualizado:</strong> {{ $pedido->updated_at->format('d/m/Y H:i') }}
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Editar Pedido -->
@if($pedido->estado === 'confirmado')
<div class="modal fade" id="editPedidoModal" tabindex="-1" aria-labelledby="editPedidoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPedidoModalLabel">
                    <i class="bi bi-pencil"></i> Editar Pedido #{{ $pedido->id }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pedidos.update', $pedido) }}" method="POST" id="editPedidoForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        <strong>Atención:</strong> Al modificar este pedido, se ajustará automáticamente el stock de los productos.
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Producto</th>
                                    <th width="120">Cantidad</th>
                                    <th width="120">Stock Disponible</th>
                                    <th width="80">Acción</th>
                                </tr>
                            </thead>
                            <tbody id="pedidoItemsTable">
                                @foreach($pedido->items as $index => $item)
                                <tr data-item-id="{{ $item->id }}">
                                    <td>
                                        @if($item->producto)
                                            <strong>{{ $item->producto->nombre }}</strong><br>
                                            <small class="text-muted">{{ $item->producto->sku }} - ${{ number_format($item->precio_unit_l1, 2) }}</small>
                                        @else
                                            <strong class="text-muted">Producto eliminado</strong><br>
                                            <small class="text-muted">N/A - ${{ number_format($item->precio_unit_l1, 2) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <input type="number" 
                                               name="items[{{ $item->id }}][cantidad]" 
                                               value="{{ $item->cantidad }}" 
                                               class="form-control" 
                                               min="1" 
                                               max="{{ $item->producto ? ($item->producto->stock_actual + $item->cantidad) : 999 }}"
                                               data-original="{{ $item->cantidad }}"
                                               {{ $item->producto ? '' : 'disabled' }}>
                                        <input type="hidden" name="items[{{ $item->id }}][producto_id]" value="{{ $item->producto ? $item->producto->id : '' }}">
                                        @if(!$item->producto)
                                            <small class="text-muted">Producto eliminado - no se puede editar</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->producto)
                                            <span class="badge bg-info">{{ $item->producto->stock_actual + $item->cantidad }}</span>
                                            <small class="text-muted d-block">Actual + Pedido</small>
                                        @else
                                            <span class="badge bg-secondary">N/A</span>
                                            <small class="text-muted d-block">Producto eliminado</small>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeItem(this)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="editPedidoForm" class="btn btn-warning">
                    <i class="bi bi-save"></i> Guardar Cambios
                </button>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@section('scripts')
<script>
function removeItem(button) {
    if (confirm('¿Estás seguro de eliminar este producto del pedido?')) {
        const row = button.closest('tr');
        const input = row.querySelector('input[name*="[cantidad]"]');
        input.value = 0; // Marcar como eliminado
        row.style.opacity = '0.5';
        button.disabled = true;
        button.innerHTML = '<i class="bi bi-check"></i>';
    }
}
</script>
@endsection