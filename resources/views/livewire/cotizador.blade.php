<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 style="color: var(--bambu-primary);"><i class="bi bi-calculator"></i> Cotizador BAMBU</h1>
        <div>
            @if(!empty($items))
                <button wire:click="limpiarCotizacion" class="btn btn-bambu-outline me-2">
                    <i class="bi bi-arrow-clockwise"></i> Limpiar
                </button>
            @endif
            <a href="{{ url('/') }}" class="btn btn-bambu-outline">
                <i class="bi bi-house"></i> Inicio
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Panel Izquierdo: Búsquedas y Formulario -->
        <div class="col-md-8">
            <!-- Búsqueda de Cliente -->
            <div class="card card-bambu mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-person-search"></i> Seleccionar Cliente</h5>
                </div>
                <div class="card-body">
                    <div class="position-relative" style="z-index: 1052;">
                        <input type="text" 
                               class="form-control form-control-bambu form-control-lg @if($clienteSeleccionado) bg-light @endif"
                               wire:model.live.debounce.300ms="searchCliente"
                               placeholder="Buscar cliente por nombre, dirección o teléfono..."
                               autocomplete="off"
                               @if($clienteSeleccionado) readonly @endif>
                        
                        @if($mostrarClientesDropdown)
                            <div class="dropdown-menu show w-100 position-absolute" style="z-index: 1055 !important;">
                                @foreach($clientesEncontrados as $cliente)
                                    <button type="button" 
                                            class="dropdown-item"
                                            wire:click="seleccionarCliente({{ $cliente['id'] }})">
                                        <div>
                                            <strong>{{ $cliente['nombre'] }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $cliente['direccion'] }} • {{ $cliente['telefono'] }}</small>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    
                    @if($clienteSeleccionado)
                        <div class="mt-3 p-3 bg-light rounded">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6><i class="bi bi-check-circle text-success"></i> Cliente Seleccionado:</h6>
                                </div>
                                <button wire:click="limpiarCliente" class="btn btn-bambu-outline btn-sm">
                                    <i class="bi bi-pencil"></i> Cambiar
                                </button>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>{{ $clienteSeleccionado->nombre }}</strong><br>
                                    <small>{{ $clienteSeleccionado->direccion }}</small>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <span class="badge badge-bambu-primary">{{ $clienteSeleccionado->ciudad->nombre }}</span><br>
                                    <small>{{ $clienteSeleccionado->telefono }}</small>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Búsqueda de Productos -->
            <div class="card card-bambu mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-search"></i> Agregar Productos</h5>
                </div>
                <div class="card-body">
                    <div class="position-relative" style="z-index: 1051;">
                        <input type="text" 
                               class="form-control form-control-bambu form-control-lg"
                               wire:model.live.debounce.300ms="searchProducto"
                               placeholder="Buscar productos por nombre o SKU..."
                               autocomplete="off">
                        
                        @if($mostrarProductosDropdown)
                            <div class="dropdown-menu show w-100 position-absolute" style="z-index: 1050 !important;">
                                @foreach($productosEncontrados as $index => $producto)
                                    <button type="button" 
                                            class="dropdown-item"
                                            wire:click="agregarProductoSimple({{ $producto->id }})"
                                            data-producto-id="{{ $producto->id }}"
                                            data-producto-nombre="{{ $producto->nombre }}">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $producto->nombre }}</strong>
                                                <br>
                                                <small class="text-muted">SKU: {{ $producto->sku }} • ID: {{ $producto->id }}</small>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge badge-bambu-primary">${{ number_format($producto->precio_base_l1, 2) }}</span>
                                                <br>
                                                <small class="text-muted">Stock: {{ $producto->stock_actual }}</small>
                                            </div>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>


            <!-- Items del Pedido -->
            @if(!empty($items))
                <div class="card card-bambu">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-cart"></i> Productos en el Pedido</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bambu table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th width="100">Cantidad</th>
                                        <th width="100">Bultos</th>
                                        <th width="120">Precio Unit.</th>
                                        <th width="120">Subtotal</th>
                                        <th width="80">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $id => $item)
                                        <tr wire:key="row-{{ $id }}">
                                            <td>
                                                <div>
                                                    <strong>{{ $item['nombre'] }}</strong>
                                                    @if($item['es_combo'])
                                                        <span class="badge badge-bambu-secondary ms-1">Combo</span>
                                                    @endif
                                                    <span class="badge badge-bambu-primary ms-1">ID: {{ $item['producto_id'] }}</span>
                                                    <br>
                                                    <small class="text-muted">SKU: {{ $item['sku'] }} • Stock: {{ $item['stock_disponible'] }} • {{ $item['peso_kg'] ?? 5 }}kg</small>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="number" 
                                                       class="form-control form-control-bambu form-control-sm"
                                                       min="1"
                                                       max="{{ $item['stock_disponible'] }}"
                                                       wire:model.live="items.{{ $id }}.cantidad">
                                            </td>
                                            <td>
                                                <span class="badge badge-bambu-primary">
                                                    {{ round(($item['cantidad'] * ($item['peso_kg'] ?? 5)) / 5, 2) }}
                                                </span>
                                                <br>
                                                <small class="text-muted">bultos</small>
                                            </td>
                                            <td>
                                                <span class="fw-bold" style="color: var(--bambu-primary);">${{ number_format($item['precio_base_l1'], 2) }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-bold" style="color: var(--bambu-primary-dark);">${{ number_format($item['subtotal'], 2) }}</span>
                                            </td>
                                            <td>
                                                <button wire:click="quitarItem('{{ $id }}')" 
                                                        class="btn btn-outline-danger btn-sm"
                                                        title="Quitar producto"
                                                        style="border-color: var(--bambu-danger); color: var(--bambu-danger);">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Panel Derecho: Totales y Resumen -->
        <div class="col-md-4">
            <!-- Totales -->
            <div class="card card-bambu mb-4 sticky-top" style="top: 20px;">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-calculator"></i> Totales</h5>
                </div>
                <div class="card-body">
                    @if(!empty($items))
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span>Subtotal:</span>
                                <span class="fw-bold">${{ number_format($montoBruto, 2) }}</span>
                            </div>
                            
                            @if($porcentajeDescuento > 0)
                                <div class="d-flex justify-content-between text-info">
                                    <span>Descuento {{ $nivelDescuento->nombre }} ({{ $porcentajeDescuento }}%):</span>
                                    <span>-${{ number_format($montoBruto - $montoFinal, 2) }}</span>
                                </div>
                                <hr>
                            @endif
                            
                            <div class="d-flex justify-content-between fs-4 fw-bold text-success">
                                <span>TOTAL:</span>
                                <span>${{ number_format($montoFinal, 2) }}</span>
                            </div>
                            
                            <hr>
                            
                            <div class="d-flex justify-content-between fs-5 fw-bold text-info">
                                <span><i class="bi bi-box"></i> BULTOS TOTALES:</span>
                                <span>{{ $bultosTotales }}</span>
                            </div>
                        </div>

                        <!-- Información de Descuentos -->
                        <div class="bg-light p-3 rounded mb-3">
                            <h6 class="fw-bold mb-2">Niveles de Descuento:</h6>
                            <small class="text-muted">
                                @foreach(\App\Models\NivelDescuento::orderBy('monto_min')->get() as $nivel)
                                    <div class="@if($nivelDescuento && $nivelDescuento->id == $nivel->id) text-success fw-bold @endif">
                                        {{ $nivel->nombre }}: {{ $nivel->porcentaje }}% (desde ${{ number_format($nivel->monto_min, 0) }})
                                    </div>
                                @endforeach
                            </small>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="d-grid gap-2">
                            @if($clienteSeleccionado)
                                <button wire:click="generarResumen" class="btn btn-outline-success">
                                    <i class="bi bi-file-text"></i> Generar Resumen
                                </button>
                                <button wire:click="confirmarPedido" 
                                        class="btn btn-success" 
                                        wire:confirm="¿Confirmar este pedido? Se descontará del stock automáticamente."
                                        wire:loading.attr="disabled"
                                        wire:target="confirmarPedido">
                                    <span wire:loading.remove wire:target="confirmarPedido">
                                        <i class="bi bi-check-circle"></i> Confirmar Pedido
                                    </span>
                                    <span wire:loading wire:target="confirmarPedido">
                                        <i class="bi bi-hourglass-split spin"></i> Confirmando...
                                    </span>
                                </button>
                            @else
                                <button class="btn btn-secondary" disabled>
                                    <i class="bi bi-exclamation-triangle"></i> Selecciona un Cliente
                                </button>
                            @endif
                        </div>
                    @else
                        <div class="text-center text-muted">
                            <i class="bi bi-cart-x display-4"></i>
                            <p class="mt-2">Agrega productos para ver los totales</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Resumen -->
    @if($mostrarResumen)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg">
                <div class="modal-content modal-content-bambu">
                    <div class="modal-header modal-header-bambu">
                        <h5 class="modal-title"><i class="bi bi-file-text"></i> Resumen de Cotización</h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="$set('mostrarResumen', false)"></button>
                    </div>
                    <div class="modal-body modal-body-bambu">
                        <div class="bg-light p-3 rounded">
                            <pre class="mb-0" style="white-space: pre-wrap; font-family: monospace;">{{ $resumenTexto }}</pre>
                        </div>
                        
                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="bi bi-info-circle"></i> 
                                Copia este texto y envíalo por WhatsApp o email al cliente.
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer modal-footer-bambu">
                        <button type="button" class="btn btn-bambu-secondary" wire:click="$set('mostrarResumen', false)">
                            Cerrar
                        </button>
                        <button type="button" class="btn btn-bambu-primary" onclick="copyToClipboard()">
                            <i class="bi bi-clipboard"></i> Copiar Texto
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Loading overlay -->
    <div wire:loading wire:target="searchCliente,searchProducto,agregarProducto,actualizarCantidad,quitarItem,generarResumen">
        <div class="position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center" 
             style="background-color: rgba(0,0,0,0.5); z-index: 99999;">
            <div class="spinner-border" style="color: var(--bambu-primary);" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        </div>
    </div>

    <style>
    /* Simple solution: Lower z-index for dropdowns when loading */
    .dropdown-menu.show {
        z-index: 1000;
    }
    
    /* Loading overlay covers everything */
    div[wire\:loading] {
        z-index: 99999 !important;
    }
    </style>
</div>

@push('styles')
<style>
.spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
@endpush

@push('scripts')
<script>
function copyToClipboard() {
    const text = document.querySelector('pre').textContent;
    navigator.clipboard.writeText(text).then(function() {
        alert('¡Resumen copiado al portapapeles!');
    });
}

// Escuchar eventos de Livewire
document.addEventListener('livewire:initialized', () => {
    // Evento cuando se agrega un producto
    Livewire.on('producto-agregado', (event) => {
        // Producto agregado exitosamente
    });
    
    // Evento de pedido confirmado
    Livewire.on('pedido-confirmado', (event) => {
        
        // Obtener el ID del pedido desde el evento
        const pedidoId = event[0]?.pedidoId || event.pedidoId || 'N/A';
        
        // Mostrar mensaje de éxito
        const alertHtml = `
            <div class="alert alert-success alert-dismissible fade show position-fixed" 
                 style="top: 20px; right: 20px; z-index: 10000; min-width: 300px;" 
                 id="pedido-confirmado-alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <div>
                        <strong>¡Pedido Confirmado!</strong><br>
                        <small>Pedido #${pedidoId} creado exitosamente</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', alertHtml);
        
        // Auto-remover después de 5 segundos
        setTimeout(() => {
            const alert = document.getElementById('pedido-confirmado-alert');
            if (alert) {
                alert.remove();
            }
        }, 5000);
    });
});
</script>
@endpush