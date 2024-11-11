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
    <header class="sticky bg-gray-50 top-0 left-0 w-full p-3 shadow-sm">
        <div class="flex flex-row gap-4 justify-start items-center">
            <!-- TÍTULO SECCIÓN -->
            <h1 class="font-bold text-lg uppercase text-pc-texto-h">
                @yield('nombre_seccion')
            </h1>
        </div>
    </header>

    <main class="flex flex-col my-8 px-8 gap-8">
        @yield('contenido')
    </main>

</body>

</html>
