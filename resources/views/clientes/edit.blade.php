@extends('layouts.app')

@section('title', 'Editar Cliente')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="bi bi-person-gear"></i> Editar Cliente
        </h5>
    </div>
    <div class="card-body">
        <form action="{{ route('clientes.update', $cliente) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombre" class="form-label">Nombre del Cliente</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                           id="nombre" name="nombre" value="{{ old('nombre', $cliente->nombre) }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control @error('direccion') is-invalid @enderror" 
                           id="direccion" name="direccion" value="{{ old('direccion', $cliente->direccion) }}" required>
                    @error('direccion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control @error('telefono') is-invalid @enderror" 
                           id="telefono" name="telefono" value="{{ old('telefono', $cliente->telefono) }}" required>
                    @error('telefono')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="ciudad_id" class="form-label">Ciudad</label>
                    <select class="form-select @error('ciudad_id') is-invalid @enderror" 
                            id="ciudad_id" name="ciudad_id" required>
                        <option value="">Seleccionar ciudad</option>
                        @foreach($ciudades as $ciudad)
                            <option value="{{ $ciudad->id }}" 
                                {{ old('ciudad_id', $cliente->ciudad_id) == $ciudad->id ? 'selected' : '' }}>
                                {{ $ciudad->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('ciudad_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="email" class="form-label">Email (opcional)</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email', $cliente->email) }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Actualizar Cliente
                </button>
            </div>
        </form>
    </div>
</div>
@endsection