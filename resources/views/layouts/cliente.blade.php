<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('titulo')</title>

    @vite('resources/css/app.css')

</head>

<body class="antialiased font-Montserrat bg-gray-100">

    <header
        class="fixed bg-gray-50 top-0 left-0 w-screen p-3 shadow-sm transition-transform h-14 lg:translate-x-0 lg:pl-64">
        <div class="flex flex-row gap-4 items-center mx-auto md:justify-between px-4">
            <!-- BOTÓN DEL MENÚ -->
            <div class="lg:hidden">
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
            <h1 class="font-bold text-lg uppercase text-pc-texto-h ml-2 transition-transform lg:translate-x-0">
                @yield('nombre_seccion')
            </h1>
            {{-- TODO: Agregar nombre, saldo, puntaje, datos importantes --}}
            <p class="hidden md:block">Perfil</p>
        </div>
    </header>


    {{-- * Para pantallas más grandes (a partir de large) * --}}
    {{-- SIDEBAR --}}
    <aside
        class="fixed top-0 left-0 w-64 h-screen transition-transform -translate-x-full bg-gray-50 shadow-sm border-r-gray-100 lg:translate-x-0 flex flex-col justify-between">

        <div class="flex flex-col gap-4 p-8 text-lg font-medium">
            {{-- USUARIO --}}
            <div>
                {{-- TODO: Pedalea Comodoro --}}
                <p class="text-center text-2xl font-semibold text-pc-texto-h border-b-2 border-pc-naranja my-8">
                    {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}
                </p>
                <ul>
                    <x-item-sidebar href="{{ route('inicio') }}">Inicio</x-item-sidebar>
                    <x-item-sidebar href="{{ route('perfil') }}">Perfil</x-item-sidebar>
                    <x-item-sidebar href="">Cargar Saldo</x-item-sidebar>
                </ul>
            </div>
            <hr>
            {{-- SECCIONES --}}
            <div class="">
                <p class="text-sm text-pc-texto-p mt-2">Reservas y Alquileres</p>
                <ul>
                    <x-item-sidebar href="">Ver Estaciones</x-item-sidebar>
                    <x-item-sidebar href="{{ route('reservar') }}">Reservar una Bicicleta</x-item-sidebar>
                    {{-- ? Que cambie la palabra (Reserva o Alquiler) según lo que tenga, si no tiene nada, que no aparezca la opción? --}}
                    <x-item-sidebar href="">Reserva/Alquiler Actual</x-item-sidebar>
                </ul>
            </div>
            <hr>
            {{-- HISTORIALES --}}
            <div class="">
                <p class="text-sm text-pc-texto-p mt-2">Historiales</p>
                <ul>
                    <x-item-sidebar href="">Movimientos del Saldo</x-item-sidebar>
                    <x-item-sidebar href="">Historial de Reservas</x-item-sidebar>
                    {{-- TODO: Que el texto de esta sección se marque de rojo o tenga un puntito si tiene una multa pendiente de pago --}}
                    <x-item-sidebar href="">Historial de Multas</x-item-sidebar>
                    <x-item-sidebar href="">Historial de Suspensiones</x-item-sidebar>
                    <li></li>
                </ul>
            </div>
        </div>
        {{-- LOGOUT --}}
        {{-- TODO: Arreglar, el cerrar sesión se fue muy abajo --}}
        <div class="p-8">
            <ul>
                <li
                    class="text-center text-base p-2 text-pc-texto-h font-medium rounded-full bg-gray-200 hover:bg-white hover:shadow-md my-1">
                    <a href="">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </aside>

    {{-- CONTENIDO PRINCIPAL --}}
    <main class="flex flex-col mt-14 p-8 gap-8  lg:ml-64 overflow-y-auto">
        @yield('contenido')
    </main>

</body>

</html>
