<?php

namespace App\Livewire;

use App\Models\Cliente;
use App\Models\Producto;
use App\Models\NivelDescuento;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\MovimientoStock;
use App\Models\SystemLog;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Cotizador extends Component
{
    // Búsqueda de cliente
    public $searchCliente = '';
    public $clienteSeleccionado = null;
    public $clientesEncontrados = [];
    public $mostrarClientesDropdown = false;

    // Búsqueda de productos
    public $searchProducto = '';
    public $productosEncontrados = [];
    public $mostrarProductosDropdown = false;

    // Items del pedido
    public $items = [];
    
    // Cálculos
    public $montoBruto = 0;
    public $nivelDescuento = null;
    public $porcentajeDescuento = 0;
    public $montoFinal = 0;
    public $bultosTotales = 0;

    // Estados
    public $mostrarResumen = false;
    public $resumenTexto = '';
    public $ultimaConfirmacion = null;
    public $hashBusqueda = null;
    public $updateKey = 0;

    public function mount()
    {
        // Inicialización simple - sin session
        $this->items = [];
        $this->calcularTotales();
    }

    // Búsqueda en tiempo real de clientes
    public function updatedSearchCliente()
    {
        if (strlen($this->searchCliente) < 2) {
            $this->clientesEncontrados = [];
            $this->mostrarClientesDropdown = false;
            return;
        }

        $this->clientesEncontrados = Cliente::search($this->searchCliente)
            ->take(10)
            ->get()
            ->toArray();
        
        $this->mostrarClientesDropdown = count($this->clientesEncontrados) > 0;
    }

    public function seleccionarCliente($clienteId)
    {
        $this->clienteSeleccionado = Cliente::with('ciudad')->find($clienteId);
        $this->searchCliente = $this->clienteSeleccionado->nombre . ' - ' . $this->clienteSeleccionado->direccion;
        $this->mostrarClientesDropdown = false;
    }

    public function limpiarCliente()
    {
        $this->clienteSeleccionado = null;
        $this->searchCliente = '';
        $this->mostrarClientesDropdown = false;
    }

    // Búsqueda en tiempo real de productos
    public function updatedSearchProducto()
    {
        // Limpiar resultados anteriores primero
        $this->productosEncontrados = collect();
        $this->mostrarProductosDropdown = false;
        
        if (strlen($this->searchProducto) < 2) {
            return;
        }

        // Usar búsqueda tradicional más confiable
        $productos = Producto::where('stock_actual', '>', 0)
            ->where(function($query) {
                $searchTerm = '%' . $this->searchProducto . '%';
                $query->where('nombre', 'LIKE', $searchTerm)
                      ->orWhere('sku', 'LIKE', $searchTerm);
            })
            ->orderBy('nombre')
            ->take(10)
            ->get();

        // Debug: Log de productos encontrados

        $this->productosEncontrados = $productos;
        $this->mostrarProductosDropdown = $productos->count() > 0;
        $this->hashBusqueda = md5($this->searchProducto . time());
    }

    public function agregarProductoSimple($productoId)
    {
        $producto = Producto::find($productoId);
        
        if (!$producto || $producto->stock_actual <= 0) {
            session()->flash('error', 'Producto sin stock disponible');
            return;
        }

        // Crear item único con ID único SIN PUNTOS para evitar problemas con Livewire
        $itemId = 'item_' . $productoId . '_' . str_replace('.', '_', microtime(true)) . '_' . rand(1000, 9999);
        
        // SOLUCION: Crear item completamente aislado con logging detallado
        $nuevoItem = [
            'id_unico' => $itemId,
            'producto_id' => (int)$producto->id,
            'nombre' => $producto->nombre,
            'sku' => $producto->sku,
            'precio_base_l1' => (float)$producto->precio_base_l1,
            'cantidad' => 1,
            'subtotal' => (float)$producto->precio_base_l1,
            'stock_disponible' => (int)$producto->stock_actual,
            'es_combo' => (bool)$producto->es_combo,
            'peso_kg' => (float)($producto->peso_kg ?? 5.0),
        ];
        
        
        // SOLUCION RADICAL: Forzar deep clone para evitar referencias compartidas
        $itemsTemp = json_decode(json_encode($this->items), true);
        $itemsTemp[$itemId] = json_decode(json_encode($nuevoItem), true);
        $this->items = $itemsTemp;
        
        
        // Limpiar búsqueda
        $this->searchProducto = '';
        $this->productosEncontrados = collect();
        $this->mostrarProductosDropdown = false;
        
        $this->calcularTotales();
        
        // Disparar evento para debug y forzar re-render
        $this->dispatch('producto-agregado', [
            'producto' => $producto->nombre,
            'id' => $producto->id,
            'count' => count($this->items),
            'itemId' => $itemId
        ]);
        
        session()->flash('success', "Producto {$producto->nombre} agregado correctamente");
        
    }


    public function actualizarCantidad($id, $cantidad)
    {
        $cantidad = (int)$cantidad;
        
        if ($cantidad <= 0) {
            $this->quitarItem($id);
            return;
        }

        if (!isset($this->items[$id])) {
            return;
        }

        if ($cantidad > $this->items[$id]['stock_disponible']) {
            session()->flash('error', 'Cantidad solicitada excede el stock disponible');
            return;
        }

        // Actualización forzada del array sin referencias
        $itemsTemp = $this->items;
        $itemsTemp[$id]['cantidad'] = $cantidad;
        $itemsTemp[$id]['subtotal'] = $cantidad * $itemsTemp[$id]['precio_base_l1'];
        $this->items = $itemsTemp;
        
        $this->calcularTotales();
    }

    public function quitarItem($id)
    {
        unset($this->items[$id]);
        $this->calcularTotales();
    }

    // Método para reaccionar a cambios en items específicos
    public function updatedItems($value, $key)
    {
        
        // Solo procesar si se cambió una cantidad
        if (str_contains($key, '.cantidad')) {
            // Extraer el ID del item del key (formato: itemId.cantidad)
            $itemId = explode('.', $key)[0];
            
            if (isset($this->items[$itemId])) {
                $cantidad = (int)$value;
                
                // Validaciones
                if ($cantidad <= 0) {
                    $this->quitarItem($itemId);
                    return;
                }
                
                if ($cantidad > $this->items[$itemId]['stock_disponible']) {
                    session()->flash('error', 'Cantidad excede stock disponible');
                    // Revertir a cantidad anterior
                    $this->items[$itemId]['cantidad'] = 1;
                    return;
                }
                
                // Actualizar subtotal
                $this->items[$itemId]['subtotal'] = $cantidad * $this->items[$itemId]['precio_base_l1'];
            }
            
            $this->calcularTotales();
        }
    }

    public function calcularTotales()
    {
        
        // Calcular monto bruto (excluyendo combos para determinar descuento)
        $montoParaDescuento = 0;
        $montoTotal = 0;

        foreach ($this->items as $item) {
            $montoTotal += $item['subtotal'];
            
            // Los combos no cuentan para el cálculo de descuento
            if (!$item['es_combo']) {
                $montoParaDescuento += $item['subtotal'];
            }
        }
        

        $this->montoBruto = $montoTotal;

        // Determinar nivel de descuento basado en monto (sin combos)
        $this->nivelDescuento = NivelDescuento::where('monto_min', '<=', $montoParaDescuento)
            ->orderBy('monto_min', 'desc')
            ->first();

        $this->porcentajeDescuento = $this->nivelDescuento ? $this->nivelDescuento->porcentaje : 0;

        // Aplicar descuento solo a productos NO combo (SIN REFERENCIA &)
        $descuentoTotal = 0;
        foreach ($this->items as $item) {
            if (!$item['es_combo']) {
                $descuentoItem = $item['subtotal'] * ($this->porcentajeDescuento / 100);
                $descuentoTotal += $descuentoItem;
            }
        }

        $this->montoFinal = $this->montoBruto - $descuentoTotal;
        
        // Calcular bultos totales
        $this->bultosTotales = 0;
        foreach ($this->items as $item) {
            $this->bultosTotales += $item['cantidad'] * ($item['peso_kg'] / 5);
        }
        $this->bultosTotales = round($this->bultosTotales, 2);
    }

    public function generarResumen()
    {
        if (!$this->clienteSeleccionado || empty($this->items)) {
            session()->flash('error', 'Debe seleccionar un cliente y agregar productos');
            return;
        }

        // Ordenar productos por prioridad (líquidos y bultos primero)
        $itemsOrdenados = collect($this->items)->sortBy(function ($item) {
            // Lógica simple: productos con "L" en el nombre van primero (líquidos)
            return strpos(strtolower($item['nombre']), 'l') !== false ? 0 : 1;
        });

        $resumen = "📋 PEDIDO BAMBU\n";
        $resumen .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
        
        $resumen .= "👤 CLIENTE:\n";
        $resumen .= "• {$this->clienteSeleccionado->nombre}\n";
        $resumen .= "• {$this->clienteSeleccionado->direccion}\n";
        $resumen .= "• {$this->clienteSeleccionado->telefono}\n";
        $resumen .= "• {$this->clienteSeleccionado->ciudad->nombre}\n\n";
        
        $resumen .= "📦 PRODUCTOS:\n";
        foreach ($itemsOrdenados as $item) {
            $resumen .= "• {$item['cantidad']}x {$item['nombre']} ({$item['sku']})\n";
        }
        
        $resumen .= "\n💰 TOTALES:\n";
        $resumen .= "• Subtotal: $" . number_format($this->montoBruto, 2) . "\n";
        
        if ($this->porcentajeDescuento > 0) {
            $resumen .= "• Descuento {$this->nivelDescuento->nombre} ({$this->porcentajeDescuento}%): -$" . number_format($this->montoBruto - $this->montoFinal, 2) . "\n";
        }
        
        $resumen .= "• TOTAL FINAL: $" . number_format($this->montoFinal, 2) . "\n\n";
        $resumen .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━";

        $this->resumenTexto = $resumen;
        $this->mostrarResumen = true;
    }

    public function confirmarPedido()
    {
        
        // Prevenir doble confirmación (menos de 3 segundos entre confirmaciones)
        $ahora = now();
        if ($this->ultimaConfirmacion && $this->ultimaConfirmacion->diffInSeconds($ahora) < 3) {
            session()->flash('error', 'Espere un momento antes de confirmar nuevamente');
            return;
        }
        
        // Validaciones básicas
        if (!$this->clienteSeleccionado || empty($this->items)) {
            session()->flash('error', 'Debe seleccionar un cliente y agregar productos');
            return;
        }

        $this->ultimaConfirmacion = $ahora;
        
        try {
            $pedido = null;
            
            DB::transaction(function () use (&$pedido) {
                // 1. Validar stock disponible para todos los productos
                foreach ($this->items as $item) {
                    $producto = Producto::find($item['producto_id']);
                    if (!$producto || $producto->stock_actual < $item['cantidad']) {
                        $stockDisponible = $producto ? $producto->stock_actual : 0;
                        throw new \Exception("Stock insuficiente para {$item['nombre']}. Disponible: {$stockDisponible}");
                    }
                }

                // 2. Crear el pedido
                $pedido = Pedido::create([
                    'cliente_id' => $this->clienteSeleccionado->id,
                    'nivel_descuento_id' => $this->nivelDescuento?->id,
                    'monto_bruto' => $this->montoBruto,
                    'monto_final' => $this->montoFinal,
                    'estado' => 'confirmado'
                ]);

                // 3. Crear los items del pedido y descontar stock
                foreach ($this->items as $item) {
                    // Crear item del pedido
                    PedidoItem::create([
                        'pedido_id' => $pedido->id,
                        'producto_id' => $item['producto_id'],
                        'cantidad' => $item['cantidad'],
                        'precio_unit_l1' => $item['precio_base_l1'],
                        'subtotal' => $item['subtotal']
                    ]);

                    // Descontar del stock y registrar movimiento
                    $producto = Producto::find($item['producto_id']);
                    $stockAnterior = $producto->stock_actual;
                    
                    // Descontar del stock
                    $producto->decrement('stock_actual', $item['cantidad']);

                    // Registrar movimiento de stock (solo campos que existen)
                    MovimientoStock::create([
                        'producto_id' => $item['producto_id'],
                        'pedido_id' => $pedido->id,
                        'cantidad' => $item['cantidad'],
                        'motivo' => "Confirmación de pedido #{$pedido->id}",
                        'created_at' => now()
                    ]);
                }
            }); // Fin de la transacción

            // 4. Log del pedido creado
            $itemsDescripcion = collect($this->items)->map(function($item) {
                return "{$item['cantidad']}x {$item['nombre']}";
            })->implode(', ');

            SystemLog::log(
                Auth::user()->name,
                "Pedido #{$pedido->id} creado para {$this->clienteSeleccionado->nombre} - Total: \${$this->montoFinal}",
                'pedidos',
                [
                    'pedido_id' => $pedido->id,
                    'cliente' => $this->clienteSeleccionado->nombre,
                    'items' => $itemsDescripcion,
                    'monto_bruto' => $this->montoBruto,
                    'monto_final' => $this->montoFinal,
                    'descuento' => $this->nivelDescuento?->nombre,
                ]
            );

            // 5. Si llegamos aquí, todo salió bien - limpiar cotización y mostrar mensaje
            
            $this->limpiarCotizacion();
            session()->flash('success', "¡Pedido #{$pedido->id} confirmado exitosamente! Stock actualizado automáticamente.");
            
            // Mensaje temporal en la interfaz
            $this->dispatch('pedido-confirmado', [
                'pedidoId' => $pedido->id,
                'mensaje' => "¡Pedido #{$pedido->id} confirmado exitosamente!"
            ]);
            

        } catch (\Exception $e) {
            \Log::error("Error al confirmar pedido: " . $e->getMessage());
            \Log::error("Stack trace: " . $e->getTraceAsString());
            
            session()->flash('error', 'Error al confirmar pedido: ' . $e->getMessage());
            // Resetear timestamp para permitir reintento
            $this->ultimaConfirmacion = null;
        }
    }

    public function limpiarCotizacion()
    {
        $this->reset([
            'searchCliente', 'clienteSeleccionado', 'searchProducto',
            'items', 'montoBruto', 'montoFinal', 'porcentajeDescuento',
            'mostrarResumen', 'resumenTexto', 'bultosTotales', 'ultimaConfirmacion'
        ]);
        
        $this->calcularTotales();
    }


    public function render()
    {
        return view('livewire.cotizador');
    }
}
