@extends('layouts.app')

@section('title', 'Cotizador BAMBU - Versión Tradicional')

@section('content')
<div class="container">
    <h1><i class="bi bi-calculator"></i> Cotizador BAMBU</h1>
    <p class="text-muted">Versión tradicional (sin Livewire) para testing</p>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Clientes Disponibles</h5>
                </div>
                <div class="card-body">
                    @foreach($clientes as $cliente)
                        <div class="border p-2 mb-2">
                            <strong>{{ $cliente->nombre }}</strong><br>
                            <small>{{ $cliente->direccion }} - {{ $cliente->telefono }}</small>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Productos Disponibles</h5>
                </div>
                <div class="card-body">
                    @foreach($productos as $producto)
                        <div class="border p-2 mb-2">
                            <strong>{{ $producto->nombre }}</strong><br>
                            <small>SKU: {{ $producto->sku }} - Stock: {{ $producto->stock_actual }}</small><br>
                            <span class="badge bg-success">${{ number_format($producto->precio_base_l1, 2) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Niveles de Descuento</h5>
                </div>
                <div class="card-body">
                    @foreach($niveles as $nivel)
                        <div class="d-inline-block border p-2 m-1">
                            <strong>{{ $nivel->nombre }}</strong><br>
                            <small>{{ $nivel->porcentaje }}% desde ${{ number_format($nivel->monto_min, 0) }}</small>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <div class="alert alert-info mt-4">
        <i class="bi bi-info-circle"></i> 
        <strong>Estado:</strong> Si ves esta página correctamente, el problema no es con Laravel sino específicamente con Livewire.
        <br>
        <a href="{{ route('cotizador') }}" class="btn btn-primary btn-sm mt-2">
            Probar Versión Livewire
        </a>
    </div>
</div>
@endsection