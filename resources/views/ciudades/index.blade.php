@extends('layouts.app')

@section('title', 'Gestión de Ciudades')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-geo-alt"></i> Gestión de Ciudades</h1>
    <a href="{{ route('ciudades.create') }}" class="btn btn-success">
        <i class="bi bi-plus"></i> Nueva Ciudad
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($ciudades->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Provincia</th>
                            <th>Código Postal</th>
                            <th>Coordenadas</th>
                            <th width="200">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ciudades as $ciudad)
                            <tr>
                                <td>{{ $ciudad->id }}</td>
                                <td>
                                    <strong>{{ $ciudad->nombre }}</strong>
                                </td>
                                <td>
                                    @if($ciudad->provincia)
                                        <span class="badge bg-info">{{ $ciudad->provincia->nombre }}</span>
                                    @else
                                        <span class="text-muted">Sin provincia</span>
                                    @endif
                                </td>
                                <td>
                                    @if($ciudad->codigo_postal)
                                        {{ $ciudad->codigo_postal }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($ciudad->latitud && $ciudad->longitud)
                                        <small>{{ $ciudad->latitud }}, {{ $ciudad->longitud }}</small>
                                    @else
                                        <span class="text-muted">Sin coordenadas</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('ciudades.show', $ciudad) }}" class="btn btn-outline-info btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('ciudades.edit', $ciudad) }}" class="btn btn-outline-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('ciudades.destroy', $ciudad) }}" method="POST" class="d-inline" 
                                              onsubmit="return confirm('¿Estás seguro de eliminar esta ciudad?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
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
            
            {{ $ciudades->links() }}
        @else
            <div class="text-center py-4">
                <i class="bi bi-geo-alt display-1 text-muted"></i>
                <h4 class="text-muted">No hay ciudades registradas</h4>
                <p class="text-muted">Comienza agregando una nueva ciudad</p>
                <a href="{{ route('ciudades.create') }}" class="btn btn-success">
                    <i class="bi bi-plus"></i> Nueva Ciudad
                </a>
            </div>
        @endif
    </div>
</div>
@endsection