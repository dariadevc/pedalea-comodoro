<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('titulo')</title>

    @vite(['resources/css/app.css'])

</head>
{{-- TODO: Ver cómo hacer para que cambie el main y el título del header según la sección en que se encuentra usando AJAX --}}
{{-- ? podemos usar AJAX si no lo mencionamos en la arquitectura del software? --}}

<body class="antialiased font-Montserrat bg-gray-100">

    {{-- TODO: Armar header para el resto de pantallas --}}
    {{-- * Solo para mobile, a partir de la pantalla small se esconde para mostrar otro header * --}}
    <header class="sticky bg-gray-50 top-0 left-0 w-full p-3 shadow-sm sm:hidden">
        <div class="flex flex-row gap-4 justify-start items-center">
            <!-- BOTÓN DEL MENÚ -->
            <div>
                <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC"
                        stroke-width="0.144"></g>
                    <g id="SVGRepo_iconCarrier">
                        <g clip-path="url(#clip0_429_11066)">
                            <path d="M3 6.00092H21M3 12.0009H21M3 18.0009H21" stroke="#292929" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                        <defs>
                            <clipPath id="clip0_429_11066">
                                <rect width="24" height="24" fill="white" transform="translate(0 0.000915527)">
                                </rect>
                            </clipPath>
                        </defs>
                    </g>
                </svg>
            </div>
            <!-- TÍTULO SECCIÓN -->
            <h1 class="font-bold text-lg uppercase text-pc-texto-h">
                @yield('nombre_seccion')
            </h1>
        </div>
    </header>

    <main class="flex flex-col my-8 px-8 gap-8">
        @yield('contenido')
    </main>
    @yield('scripts') {{-- Aquí se cargarán los scripts específicos de cada vista --}}

    @vite('resources/js/app.js') <!-- Para Laravel 9 o superior con Vite -->
</body>

</html>
