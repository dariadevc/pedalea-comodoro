<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('titulo')</title>

    @vite('resources/css/app.css')

</head>
{{-- TODO: Ver cómo hacer para que cambie el main y el título del header según la sección en que se encuentra usando AJAX --}}
{{-- ? podemos usar AJAX si no lo mencionamos en la arquitectura del software? --}}

<body class="antialiased font-Montserrat bg-gray-100">

    {{-- TODO: Armar header para el resto de pantallas --}}
    {{-- * Solo para mobile, a partir de la pantalla small se esconde para mostrar otro header * --}}
    <header class="sticky bg-gray-50 top-0 left-0 w-full p-3 shadow-sm h-20">
        <div class="flex flex-row gap-4 justify-between">
            <!-- TÍTULO SECCIÓN -->
            <h1 class="font-bold text-lg uppercase text-pc-texto-h place-self-center">
                @yield('nombre_seccion')
            </h1>
            <div class="relative group">
                <a href="{{ route('manual.descargar', ['archivo' => 'manual_inspector']) }}"
                    class="p-2 inline-flex justify-center items-center rounded-full hover:shadow-md hover:border-2 hover:border-pc-rojo"
                    target="_blank">
                    <x-icon-manual-oscuro class="w-8 h-8" />
                </a>
                <span
                    class="absolute right-full top-3/4 transform -translate-y-1/2 mr-2 hidden group-hover:flex items-center justify-center text-white bg-pc-rojo text-sm rounded px-2 py-1 z-10 overflow-hidden">
                    Descargar Manual de Usuario
                </span>
            </div>
        </div>
    </header>

    <main class="flex flex-col my-8 px-8 gap-8">
        @yield('contenido')
    </main>

</body>

</html>
