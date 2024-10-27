<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('titulo')</title>

    {{-- Iconos UI --}}
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-bold-rounded/css/uicons-bold-rounded.css'>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="antialiased font-Montserrat bg-gray-50">
    <header class=" bg-pc-rojo sticky top-0 w-full left-0 z-10 py-1">
        @yield('header')


    </header>

    <main class="">
        @yield('contenido')
    </main>
    {{-- TODO: Arreglar->En tamaño md e inferiores el footer no queda al fondo (probablemente porque el main no ocupa toda la pantalla) --}}
    <footer class="bottom-0 w-full left-0 bg-slate-100 py-10 relative">
        <div class="container">
            <div class="mt-15 text-center">
                <p class="text-gray-500">© 2024 Pedalea Comodoro.</p>
            </div>
        </div>
    </footer>
    @yield('scripts')
</body>

</html>
