<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('titulo')</title>

    @vite('resources/css/app.css')

</head>

<body class="antialiased font-Montserrat bg-gray-50">
    <header class=" bg-pc-rojo sticky top-0 w-full left-0 z-10 py-1">
        <nav class="container flex items-center">
            <a href="@yield('href_inicio')">
                <div class="py-1 flex items-center gap-4 text-slate-50 uppercase text-sm font-semibold">
                    <img src="{{ asset('img/bicicleta_blanca.png') }}" alt="" class="h-14">
                    <h2 class="">Pedalea Comodoro</h2>
                </div>
            </a>
            <ul
                class="hidden lg:flex flex-1 justify-end items-center gap-10 text-slate-50 uppercase text-sm font-semibold">
                <li><a href="#introduccion">Inicio</a></li>
                <li><a href="#estadisticas">Estadísticas</a></li>
                <li><a href="#como-funciona">¿Cómo funciona?</a></li>
                <li><a href="#mapa">Estaciones</a></li>
                <!-- BOTÓN -->
                <button type="button"
                    class="btn bg-slate-50 text-pc-rojo rounded-full px-6 py-3 uppercase hover:bg-pc-rojo hover:text-slate-50 hover:outline hover:outline-4 hover:-outline-offset-4 hover: outline-slate-50 "><a
                        href="iniciar_sesion.html">Iniciar Sesión</a></button>
            </ul>
            <div class="flex lg:hidden flex-1 justify-end">
                <div>
                    <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC"
                            stroke-width="0.144"></g>
                        <g id="SVGRepo_iconCarrier">
                            <g clip-path="url(#clip0_429_11066)">
                                <path d="M3 6.00092H21M3 12.0009H21M3 18.0009H21" stroke="#ffffff" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0_429_11066">
                                    <rect width="24" height="24" fill="white"
                                        transform="translate(0 0.000915527)"></rect>
                                </clipPath>
                            </defs>
                        </g>
                    </svg>
                </div>
            </div>
        </nav>
    </header>

    <main>
        @yield('contenido')
    </main>

    <footer class="bottom-0 w-full left-0 bg-slate-100 py-10 relative">
        <div class="container">
            <div class="mt-15 text-center">
                <p class="text-gray-500">© 2024 Pedalea Comodoro.</p>
            </div>
        </div>
    </footer>
</body>

</html>
