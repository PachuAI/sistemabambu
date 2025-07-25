<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-calculator"></i> Cotizador BAMBU</h1>
        <div>
            @if(!empty($items))
                <button wire:click="limpiarCotizacion" class="btn btn-outline-secondary me-2">
                    <i class="bi bi-arrow-clockwise"></i> Limpiar
                </button>
            @endif
            <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                <i class="bi bi-house"></i> Inicio
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Panel Izquierdo: Búsquedas y Formulario -->
        <div class="col-md-8">
            <!-- Búsqueda de Cliente -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-person-search"></i> Seleccionar Cliente</h5>
                </div>
                <div class="card-body">
                    <div class="position-relative">
                        <input type="text" 
                               class="form-control form-control-lg @if($clienteSeleccionado) bg-light @endif"
                               wire:model.live.debounce.300ms="searchCliente"
                               placeholder="Buscar cliente por nombre, dirección o teléfono..."
                               autocomplete="off"
                               @if($clienteSeleccionado) readonly @endif>
                        
                        @if($mostrarClientesDropdown)
                            <div class="dropdown-menu show w-100 position-absolute" style="z-index: 1000;">
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
                                <button wire:click="limpiarCliente" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-pencil"></i> Cambiar
                                </button>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>{{ $clienteSeleccionado->nombre }}</strong><br>
                                    <small>{{ $clienteSeleccionado->direccion }}</small>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <span class="badge bg-info">{{ $clienteSeleccionado->ciudad->nombre }}</span><br>
                                    <small>{{ $clienteSeleccionado->telefono }}</small>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Búsqueda de Productos -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-search"></i> Agregar Productos</h5>
                </div>
                <div class="card-body">
                    <div class="position-relative">
                        <input type="text" 
                               class="form-control form-control-lg"
                               wire:model.live.debounce.300ms="searchProducto"
                               placeholder="Buscar productos por nombre o SKU..."
                               autocomplete="off">
                        
                        @if($mostrarProductosDropdown)
                            <div class="dropdown-menu show w-100 position-absolute" style="z-index: 1000;">
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
                                                <span class="badge bg-success">${{ number_format($producto->precio_base_l1, 2) }}</span>
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

            <!-- DEBUG: JSON de items -->
            <pre style="background:#222;color:#0f0;padding:.5rem">
                {{ json_encode($items, JSON_PRETTY_PRINT) }}
            </pre>

            <!-- Items del Pedido -->
            @if(!empty($items))
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="bi bi-cart"></i> Productos en el Pedido</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
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
                                                        <span class="badge bg-warning ms-1">Combo</span>
                                                    @endif
                                                    <span class="badge bg-primary ms-1">ID: {{ $item['producto_id'] }}</span>
                                                    <br>
                                                    <small class="text-muted">SKU: {{ $item['sku'] }} • Stock: {{ $item['stock_disponible'] }} • {{ $item['peso_kg'] ?? 5 }}kg</small>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="number" 
                                                       class="form-control form-control-sm"
                                                       min="1"
                                                       max="{{ $item['stock_disponible'] }}"
                                                       wire:model.defer="items.{{ $id }}.cantidad">
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ round(($item['cantidad'] * ($item['peso_kg'] ?? 5)) / 5, 2) }}
                                                </span>
                                                <br>
                                                <small class="text-muted">bultos</small>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-success">${{ number_format($item['precio_base_l1'], 2) }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-bold">${{ number_format($item['subtotal'], 2) }}</span>
                                            </td>
                                            <td>
                                                <button wire:click="quitarItem('{{ $id }}')" 
                                                        class="btn btn-outline-danger btn-sm"
                                                        title="Quitar producto">
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
            <div class="card mb-4 sticky-top" style="top: 20px;">
                <div class="card-header bg-dark text-white">
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
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title"><i class="bi bi-file-text"></i> Resumen de Cotización</h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="$set('mostrarResumen', false)"></button>
                    </div>
                    <div class="modal-body">
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('mostrarResumen', false)">
                            Cerrar
                        </button>
                        <button type="button" class="btn btn-success" onclick="copyToClipboard()">
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
             style="background-color: rgba(0,0,0,0.3); z-index: 9999;">
            <div class="spinner-border text-success" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        </div>
    </div>
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
        console.log('✅ Producto agregado:', event[0] || event);
        
        // Detectar tabla de productos para debug
        const tabla = document.querySelector('tbody');
        if (tabla) {
            const filas = tabla.querySelectorAll('tr');
            console.log('📊 Filas en tabla:', filas.length);
            
            // Debug: mostrar IDs únicos de cada fila
            filas.forEach((fila, index) => {
                const idUnico = fila.querySelector('small')?.textContent.match(/Único: (item_\d+_[\d.]+_\d+)/)?.[1];
                console.log(`Fila ${index}: ${idUnico}`);
            });
        }
    });
    
    // Evento de pedido confirmado
    Livewire.on('pedido-confirmado', (event) => {
        console.log('Evento pedido-confirmado recibido:', event);
        
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