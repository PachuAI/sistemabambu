<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-g">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title ?? 'Sistema Stock Bambu' }}</title>
        @livewireStyles
    </head>
    <body>
        {{-- Aquí se mostrará el contenido de tu componente --}}
        {{ $slot }}

        @livewireScripts
    </body>
</html>