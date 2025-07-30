<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema BAMBU')</title>
    
    <!-- Vite CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Heroicons -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    @livewireStyles
    @stack('styles')
</head>
<body class="bg-gray-950 text-text-primary antialiased">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="hidden lg:flex lg:flex-shrink-0">
            <div class="flex flex-col w-64">
                <div class="flex flex-col flex-grow bg-primary-900 overflow-y-auto shadow-xl">
                    <!-- Header del Sidebar -->
                    <div class="flex items-center flex-shrink-0 px-6 py-6 border-b border-primary-800">
                        <div class="flex items-center">
                            <svg class="w-8 h-8 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <div class="ml-3">
                                <h1 class="text-xl font-bold text-white">BAMBU Stock</h1>
                                <p class="text-sm text-primary-300">Sistema de Gestión</p>
                            </div>
                        </div>
                    </div>

                    <!-- Navegación -->
                    <nav class="flex-1 px-3 mt-6 space-y-1">
                        <!-- Dashboard -->
                        <a href="{{ url('/') }}" class="flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->is('/') ? 'bg-primary-800 text-white shadow-sm' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Dashboard
                        </a>

                        <!-- Clientes -->
                        <a href="{{ route('clientes.index') }}" class="flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('clientes.*') ? 'bg-primary-800 text-white shadow-sm' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            Clientes
                        </a>

                        <!-- Productos -->
                        <a href="{{ route('productos.index') }}" class="flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('productos.*') ? 'bg-primary-800 text-white shadow-sm' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Productos
                        </a>

                        <!-- Ciudades -->
                        <a href="{{ route('ciudades.index') }}" class="flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('ciudades.*') ? 'bg-primary-800 text-white shadow-sm' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Ciudades
                        </a>

                        <!-- Cotizador -->
                        <a href="{{ route('cotizador') }}" class="flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('cotizador*') ? 'bg-primary-800 text-white shadow-sm' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            Cotizador
                        </a>

                        <!-- Pedidos -->
                        <a href="{{ route('pedidos.index') }}" class="flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('pedidos.*') ? 'bg-primary-800 text-white shadow-sm' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Pedidos
                        </a>

                        <!-- Sección Repartos -->
                        <div class="pt-4">
                            <p class="px-3 text-xs font-semibold text-primary-400 uppercase tracking-wider">Logística</p>
                            
                            <!-- Vehículos -->
                            <a href="{{ route('vehiculos.index') }}" class="flex items-center px-3 py-3 mt-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('vehiculos.*') ? 'bg-primary-800 text-white shadow-sm' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Vehículos
                            </a>

                            <!-- Planificación -->
                            <a href="{{ route('repartos.index') }}" class="flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('repartos.*') ? 'bg-primary-800 text-white shadow-sm' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Planificación
                            </a>

                            <!-- Seguimiento -->
                            <a href="{{ route('seguimiento.entregas') }}" class="flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('seguimiento.*') ? 'bg-primary-800 text-white shadow-sm' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Seguimiento
                            </a>
                        </div>

                        <!-- Administración -->
                        <div class="pt-4">
                            <p class="px-3 text-xs font-semibold text-primary-400 uppercase tracking-wider">Sistema</p>
                            
                            <!-- Logs -->
                            <a href="{{ route('system-logs.index') }}" class="flex items-center px-3 py-3 mt-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('system-logs.*') ? 'bg-primary-800 text-white shadow-sm' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Logs
                            </a>
                        </div>
                    </nav>

                    <!-- Usuario y configuración -->
                    <div class="flex-shrink-0 border-t border-primary-800">
                        <div class="px-3 py-4" x-data="{ open: false }">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-primary-600 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-medium text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-primary-300">Administrador</p>
                                </div>
                                <button @click="open = !open" class="flex-shrink-0 p-1 rounded-full text-primary-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-primary-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            <!-- Dropdown Menu -->
                            <div x-show="open" x-transition class="mt-3 space-y-1">
                                <a href="/admin" target="_blank" class="flex items-center px-3 py-2 text-sm text-primary-300 rounded-lg hover:bg-primary-800 hover:text-white transition-colors">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Panel Admin
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-3 py-2 text-sm text-primary-300 rounded-lg hover:bg-primary-800 hover:text-white transition-colors">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Cerrar Sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu button -->
        <div class="lg:hidden fixed top-0 left-0 z-40 p-4">
            <button x-data x-on:click="$store.sidebar.toggle()" class="p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Contenido principal -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header superior -->
            <header class="bg-gray-900 shadow-sm border-b border-gray-800">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-semibold text-text-primary">@yield('page-title', 'Dashboard')</h1>
                            @hasSection('page-subtitle')
                                <p class="mt-1 text-sm text-text-muted">@yield('page-subtitle')</p>
                            @endif
                        </div>
                        <div class="flex items-center space-x-4">
                            @hasSection('header-actions')
                                @yield('header-actions')
                            @endif
                            
                            <!-- Indicadores de notificación -->
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-900/30 text-primary-300">
                                    {{ date('d/m/Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Contenido de la página -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-950">
                <div class="max-w-7xl mx-auto px-6 py-6">
                    <!-- Alertas -->
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-900/30 border border-green-700/50 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-sm text-green-300">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 p-4 bg-red-900/30 border border-red-700/50 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-sm text-red-300">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-6 p-4 bg-red-900/30 border border-red-700/50 rounded-lg">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-red-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <h6 class="text-sm font-medium text-red-300 mb-2">Por favor corrige los siguientes errores:</h6>
                                    <ul class="text-sm text-red-300 space-y-1">
                                        @foreach($errors->all() as $error)
                                            <li>• {{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Alpine.js store para manejar sidebar móvil
        document.addEventListener('alpine:init', () => {
            Alpine.store('sidebar', {
                open: false,
                toggle() {
                    this.open = !this.open
                }
            })
        })
    </script>
    
    @livewireScripts
    @stack('scripts')
    @yield('scripts')
</body>
</html>