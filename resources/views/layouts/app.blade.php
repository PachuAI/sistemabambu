<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema BAMBU')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/bambu-theme.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
        }
        
        /* Estilos personalizados para paginación */
        .pagination .page-link {
            padding: 0.25rem 0.5rem !important;
            font-size: 0.75rem !important;
            line-height: 1.2 !important;
            min-width: 2rem !important;
            min-height: 2rem !important;
            border-color: var(--bambu-primary);
            color: var(--bambu-primary);
        }
        
        .pagination .page-link:hover {
            background-color: var(--bambu-secondary-light);
            border-color: var(--bambu-primary);
        }
        
        .pagination .page-item.active .page-link {
            background-color: var(--bambu-primary);
            border-color: var(--bambu-primary);
        }
        
        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            padding: 0.25rem 0.4rem !important;
            font-size: 0.8rem !important;
        }
        
        .pagination {
            margin-bottom: 0 !important;
        }
        
        /* Mejoras generales */
        .container {
            max-width: 1400px;
        }
        
        /* Animación suave para toda la página */
        main {
            animation: bambu-fade-in 0.6s ease-out;
        }
    </style>
    @livewireStyles
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-bambu">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-boxes me-2"></i>BAMBU Stock
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('clientes.index') }}">
                            <i class="bi bi-people me-1"></i>Clientes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('productos.index') }}">
                            <i class="bi bi-box-seam me-1"></i>Productos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ciudades.index') }}">
                            <i class="bi bi-geo-alt me-1"></i>Ciudades
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cotizador') }}">
                            <i class="bi bi-calculator me-1"></i>Cotizador
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pedidos.index') }}">
                            <i class="bi bi-receipt me-1"></i>Pedidos
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-truck me-1"></i>Repartos
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('vehiculos.index') }}">
                                    <i class="bi bi-truck-front me-2"></i>Vehículos
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('repartos.index') }}">
                                    <i class="bi bi-calendar-check me-2"></i>Planificación
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('seguimiento.entregas') }}">
                                    <i class="bi bi-geo-alt me-2"></i>Seguimiento
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('system-logs.index') }}">
                            <i class="bi bi-journal-text me-1"></i>Logs
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="/admin" target="_blank">
                                    <i class="bi bi-gear me-2"></i>Panel Admin
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show bambu-fade-in" style="border-left: 4px solid var(--bambu-success); background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%);">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show bambu-fade-in" style="border-left: 4px solid var(--bambu-danger); background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%);">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show bambu-fade-in" style="border-left: 4px solid var(--bambu-danger); background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%);">
                <h6 class="mb-2"><i class="bi bi-exclamation-triangle-fill me-2"></i>Por favor corrige los siguientes errores:</h6>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
    @stack('scripts')
    @yield('scripts')
</body>
</html>