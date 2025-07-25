@extends('layouts.app')

@section('title', 'Cliente: ' . $cliente->nombre)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-person"></i> {{ $cliente->nombre }}</h1>
    <div class="btn-group">
        <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Editar
        </a>
        <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Nombre/Referencia:</dt>
                    <dd class="col-sm-9">{{ $cliente->nombre }}</dd>
                    
                    <dt class="col-sm-3">Dirección:</dt>
                    <dd class="col-sm-9">{{ $cliente->direccion }}</dd>
                    
                    <dt class="col-sm-3">Teléfono:</dt>
                    <dd class="col-sm-9">{{ $cliente->telefono }}</dd>
                    
                    @if($cliente->email)
                    <dt class="col-sm-3">Email:</dt>
                    <dd class="col-sm-9">
                        <a href="mailto:{{ $cliente->email }}">{{ $cliente->email }}</a>
                    </dd>
                    @endif
                    
                    <dt class="col-sm-3">Ciudad:</dt>
                    <dd class="col-sm-9">
                        <span class="badge bg-info">{{ $cliente->ciudad->nombre ?? 'Sin ciudad' }}</span>
                    </dd>
                    
                    <dt class="col-sm-3">Creado:</dt>
                    <dd class="col-sm-9">{{ $cliente->created_at->format('d/m/Y H:i') }}</dd>
                    
                    <dt class="col-sm-3">Actualizado:</dt>
                    <dd class="col-sm-9">{{ $cliente->updated_at->format('d/m/Y H:i') }}</dd>
                </dl>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-graph-up"></i> Historial</h5>
            </div>
            <div class="card-body text-center">
                <p class="text-muted">Próximamente: historial de pedidos y cotizaciones</p>
            </div>
        </div>
    </div>
</div>
@endsection