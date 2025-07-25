@extends('layouts.app')

@section('title', 'Pedidos Confirmados')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-receipt"></i> Pedidos Confirmados</h1>
    <a href="{{ route('cotizador') }}" class="btn btn-success">
        <i class="bi bi-plus"></i> Nuevo Pedido
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($pedidos->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Ciudad</th>
                            <th>Bultos</th>
                            <th>Monto Total</th>
                            <th>Descuento</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th width="120">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedidos as $pedido)
                            <tr>
                                <td>
                                    <strong>#{{ $pedido->id }}</strong>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $pedido->cliente->nombre }}</strong><br>
                                        <small class="text-muted">{{ $pedido->cliente->direccion }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $pedido->cliente->ciudad->nombre }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary fs-6">
                                        {{ $pedido->bultos_totales }}
                                    </span>
                                    <br>
                                    <small class="text-muted">bultos</small>
                                </td>
                                <td>
                                    <div>
                                        <strong>${{ number_format($pedido->monto_final, 2) }}</strong>
                                        @if($pedido->monto_bruto != $pedido->monto_final)
                                            <br><small class="text-muted">Bruto: ${{ number_format($pedido->monto_bruto, 2) }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($pedido->nivelDescuento)
                                        <span class="badge bg-warning text-dark">{{ $pedido->nivelDescuento->nombre }}</span>
                                        <br><small>{{ $pedido->nivelDescuento->porcentaje }}%</small>
                                    @else
                                        <span class="text-muted">Sin descuento</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $badgeClass = match($pedido->estado) {
                                            'confirmado' => 'bg-success',
                                            'en_reparto' => 'bg-primary',
                                            'entregado' => 'bg-secondary',
                                            'cancelado' => 'bg-danger',
                                            default => 'bg-warning'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ ucfirst($pedido->estado) }}</span>
                                </td>
                                <td>
                                    <div>
                                        {{ $pedido->created_at->format('d/m/Y') }}<br>
                                        <small class="text-muted">{{ $pedido->created_at->format('H:i') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('pedidos.show', $pedido) }}" class="btn btn-outline-info btn-sm" title="Ver detalle">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if($pedido->estado === 'confirmado')
                                            <a href="{{ route('pedidos.show', $pedido) }}#editPedidoModal" class="btn btn-outline-warning btn-sm" title="Editar pedido">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        @endif
                                        <form action="{{ route('pedidos.destroy', $pedido) }}" method="POST" 
                                              style="display: inline-block" 
                                              onsubmit="return confirm('¿Está seguro de eliminar este pedido? Se devolverá automáticamente el stock.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Eliminar pedido">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{ $pedidos->links() }}
        @else
            <div class="text-center py-4">
                <i class="bi bi-receipt display-1 text-muted"></i>
                <h4 class="text-muted">No hay pedidos confirmados</h4>
                <p class="text-muted">Los pedidos confirmados desde el cotizador aparecerán aquí</p>
                <a href="{{ route('cotizador') }}" class="btn btn-success">
                    <i class="bi bi-plus"></i> Crear Primer Pedido
                </a>
            </div>
        @endif
    </div>
</div>
@endsection