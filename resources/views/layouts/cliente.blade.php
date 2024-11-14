<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Pedalea Comodoro</title>

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/layout-app.js'])

</head>

<body class="antialiased font-Montserrat bg-gray-100">


    <div x-data="{ active: 'inicio', open: false }" @resize.window="if (window.innerWidth >= 1024) open = true" @click.away="open = false"
        x-init="window.addEventListener('resize', () => {
            if (window.innerWidth < 1024) open = false;
        });">

        <header
            class="fixed bg-gray-50 top-0 left-0 w-screen p-3 shadow-sm transition-transform h-14 md:translate-y-0 lg:-translate-y-full lg:pl-64 lg:hidden duration-500">
            <div class="flex items-center mx-auto justify-between px-4">
                <!-- BOTÓN DEL MENÚ -->
                <div class="hidden md:block absolute">
                    <button @click="open= !open">
                        <x-icon-hmenu-oscuro height="30px" width="30px" />
                    </button>
                </div>
                <!-- TÍTULO SECCIÓN -->
                <div class="flex flex-1 justify-center">
                    <h1 class="lg:hidden font-bold text-lg uppercase text-pc-texto-h ml-2 transition-transform">
                        @yield('nombre_seccion')
                    </h1>
                </div>
            </div>
        </header>


        {{-- * Para pantallas grandes (a partir de medium es un desplegable, desde large queda fijo) * --}}
        {{-- SIDEBAR --}}
        <aside x-show="open || window.innerWidth >= 1024"
            x-transition:enter="transition-transform transform duration-500"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition-transform transform duration-500" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed top-0 left-0 w-64 h-screen bg-gray-50 shadow-sm border-r border-gray-100 lg:translate-x-0 lg:block z-40">
            {{-- CRUZ --}}
            <div class="place-self-end block lg:hidden">
                <button @click="open = !open" class="p-2">
                    <x-icon-cruz-oscura height="20px" width="20px" />
                </button>
            </div>
            <div class="flex flex-col justify-between h-full p-8">
                <div class="flex flex-col gap-4text-lg font-medium">
                    {{-- LOGO --}}
                    <div
                        class="py-1 flex flex-col items-center gap-4 text-pc-texto-h uppercase text-lg font-bold text-center">
                        <img src="{{ asset('img/bicicleta.png') }}" alt="" class="h-12">
                        <h2 class="">Pedalea Comodoro</h2>
                    </div>

                    {{-- * BOTONES DEL SIDEBAR --}}
                    {{-- USUARIO --}}
                    <div class="text-sm">
                        <ul>
                            <x-item-sidebar ruta="inicio" @click="open = false">Inicio</x-item-sidebar>
                            <x-item-sidebar ruta="perfil" @click="open = false">Perfil</x-item-sidebar>
                            <x-item-sidebar ruta="cargar-saldo.index" @click="open = false">Cargar
                                Saldo</x-item-sidebar>
                        </ul>
                    </div>
                    <hr>
                    {{-- SECCIONES --}}
                    <div class="text-sm">
                        <p class="text-pc-rojo mt-2">Reservas y Alquileres</p>
                        <ul>
                            <x-item-sidebar ruta="actividad" @click="open = false">Actividad</x-item-sidebar>
                            @php
                                $tieneReserva = isset($reserva);
                                $estadoReserva = $tieneReserva ? $reserva->id_estado : null;
                            @endphp

                            @if ($tieneReserva)
                                @if ($estadoReserva == 1 || $estadoReserva == 5)
                                    {{-- 1 = activa, 5 = modificada --}}
                                    <x-item-sidebar ruta="reserva_actual" @click="open = false">Reserva
                                        Actual</x-item-sidebar>
                                @elseif ($estadoReserva == 2 || $estadoReserva == 6)
                                    {{-- 2 = alquilada, 6 = reasignada --}}
                                    <x-item-sidebar ruta="alquiler_actual" @click="open = false">Alquiler
                                        Actual</x-item-sidebar>
                                @else
                                    <x-item-sidebar ruta="reservar" @click="open = false">Reservar
                                        Bicicleta</x-item-sidebar>
                                @endif
                            @else
                                <x-item-sidebar ruta="reservar" @click="open = false">Reservar
                                    Bicicleta</x-item-sidebar>
                            @endif
                            <x-item-sidebar ruta="ver-mapa" @click="open = false"> Estaciones</x-item-sidebar>
                        </ul>
                    </div>
                    <hr>
                    {{-- HISTORIALES --}}
                    <div class="text-sm">
                        <p class="text-pc-rojo mt-2">Historiales</p>
                        <ul>
                            <x-item-sidebar ruta="mov_saldo" @click="open = false">Movimientos del
                                Saldo</x-item-sidebar>
                            {{-- TODO: Que el texto de esta sección se marque de rojo o tenga un puntito si tiene una multa pendiente de pago --}}
                            <x-item-sidebar ruta="his_multas" @click="open = false">Multas</x-item-sidebar>
                            <x-item-sidebar ruta="his_suspensiones" @click="open = false">Suspensiones</x-item-sidebar>
                        </ul>
                    </div>

                </div>

                <div class="flex flex-col gap-2 justify-center items-center">
                    <div class="relative group">
                        <a href="{{ route('manual.descargar', ['archivo' => 'manual_cliente']) }}"
                            class="p-2 inline-flex justify-center items-center rounded-full hover:shadow-md hover:border-2 hover:border-pc-rojo"
                            target="_blank">
                            <x-icon-manual-oscuro class="w-8 h-8" />
                        </a>
                        <span
                            class="absolute left-full top-1/2 transform -translate-y-1/2 ml-2 hidden group-hover:flex items-center justify-center text-white bg-pc-rojo text-sm rounded px-2 py-1 z-10"">
                            Descargar Manual de Usuario
                        </span>
                    </div>
                    {{-- LOGOUT --}}
                    <div class="place-self-center">

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="text-center text-base py-2 px-4 text-pc-texto-h font-medium rounded-full bg-gray-200 hover:bg-white hover:shadow-md my-1">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>
    </div>

    {{-- * Para vista sm (MOBILE) * --}}
    {{-- NAVBAR INFERIOR --}}
    <div>
        <nav class="bg-gray-50 fixed bottom-0 left-0 w-screen h-20 md:hidden shadow-[0_-2px_4px_0_rgba(0,0,0,0.05)]"
            x-transition:enter="transition-transform transform duration-500"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition-transform transform duration-500" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full">

            {{-- BOTONES DEL NAV MOBILE --}}
            <div class="h-full px-8 flex justify-between items-center text-sm">
                {{-- INICIO --}}
                {{-- TODO: Cuando estas en una sección el color del fondo del icono cambia de color y la fuente pasa a bold --}}
                <a id="inicio"
                    class=" flex flex-col justify-center items-center gap-1 p-1 @if (Request::routeIs('inicio')) bg-pc-rojo text-white font-bold hover:bg-transparent hover:text-current @endif"
                    href="{{ route('inicio') }}">
                    <x-icon-casa-oscura height="30px" width="30px" />
                    <p class="font-semibold text-pc-texto-p">Inicio</p>
                </a>
                {{-- RESERVAR/ALQUILAR --}}
                <a id="reservar"
                    class=" flex flex-col justify-center items-center gap-1 p-1 @if (Request::routeIs('reservar')) bg-pc-rojo text-white font-bold hover:bg-transparent hover:text-current @endif"
                    href="{{ route('reservar') }}">
                    <x-icon-bicicleta-oscura height="30px" width="30px" />
                    <p class="font-semibold text-pc-texto-p ">Reservar</p>
                </a>
                {{-- ESTACIONES --}}
                <a id="estaciones"
                    class=" flex flex-col justify-center items-center gap-1 p-1 @if (Request::routeIs('ver-mapa')) bg-pc-rojo text-white font-bold hover:bg-transparent hover:text-current @endif"
                    href="{{ route('ver-mapa') }}">
                    <x-icon-mapa-oscuro height="30px" width="30px" />
                    <p class="font-semibold text-pc-texto-p">Estaciones</p>
                </a>
                {{-- MÁS OPCIONES --}}
                <a id="más"
                    class=" flex flex-col justify-center items-center gap-1 p-1 @if (Request::routeIs('mas')) bg-pc-rojo text-white font-bold hover:bg-transparent hover:text-current @endif"
                    href="{{ route('mas') }}">
                    <x-icon-puntos-oscuros height="30px" width="30px" />
                    <p class="font-semibold text-pc-texto-p">Más</p>
                </a>
            </div>
        </nav>
    </div>


    {{-- CONTENIDO PRINCIPAL --}}
    <main id="main"
        class="flex flex-col md:flex-row gap-6 mt-14 mb-20 p-8 lg:ml-64 overflow-y-auto overflow-x-hidden justify-center items-center">
        @yield('contenido')
    </main>

    @yield('scripts')
</body>

</html>
