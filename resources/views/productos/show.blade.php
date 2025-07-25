@extends('layouts.app')

@section('title', 'Detalle del Producto')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">
            <i class="bi bi-box-seam"></i> Detalle del Producto
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="text-muted">Información General</h6>
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Nombre:</th>
                        <td>{{ $producto->nombre }}</td>
                    </tr>
                    <tr>
                        <th>SKU:</th>
                        <td>{{ $producto->sku }}</td>
                    </tr>
                    <tr>
                        <th>Tipo:</th>
                        <td>
                            @if($producto->es_combo)
                                <span class="badge bg-warning text-dark">Combo</span>
                            @else
                                <span class="badge bg-info">Producto Regular</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Peso:</th>
                        <td>{{ $producto->peso_kg }} kg</td>
                    </tr>
                    <tr>
                        <th>Bultos por unidad:</th>
                        <td>{{ $producto->bultos }} bultos</td>
                    </tr>
                    @if($producto->descripcion)
                    <tr>
                        <th>Descripción:</th>
                        <td>{{ $producto->descripcion }}</td>
                    </tr>
                    @endif
                </table>
            </div>
            
            <div class="col-md-6">
                <h6 class="text-muted">Precio y Stock</h6>
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Precio Base L1:</th>
                        <td><strong>${{ number_format($producto->precio_base_l1, 2) }}</strong></td>
                    </tr>
                    <tr>
                        <th>Stock Actual:</th>
                        <td>
                            <strong>{{ $producto->stock_actual }}</strong> unidades
                            @if($producto->stock_actual <= 10)
                                <span class="badge bg-danger ms-2">Stock Bajo</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver al listado
            </a>
            <div>
                <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Editar
                </a>
                <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" 
                            onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                        <i class="bi bi-trash"></i> Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection