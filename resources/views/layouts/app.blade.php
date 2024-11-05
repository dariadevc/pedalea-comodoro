<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pedalea Comodoro</title>

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/layout-app.js'])

</head>

<body class="antialiased font-Montserrat bg-gray-100">


    <div x-data="{ active: 'inicio' }">
        {{-- Este contenedor es para que el botón del menú que está en el header y la sidebar compartan la información del open --}}
        <div x-data="{ open: false }" @resize.window="if (window.innerWidth >= 1024) open = true" @click.away="open = false"
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
                x-transition:leave="transition-transform transform duration-500"
                x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                class="fixed top-0 left-0 w-64 h-screen bg-gray-50 shadow-sm border-r border-gray-100 lg:translate-x-0 lg:block z-40">
                {{-- CRUZ --}}
                <div class="place-self-end block lg:hidden">
                    <button @click="open = false" class="p-2">
                        <x-icon-cruz-oscura height="20px" width="20px" />
                    </button>
                </div>
                <div class="flex flex-col gap-4 p-8 text-lg font-medium">
                    {{-- LOGO --}}
                    <div
                        class="py-1 flex flex-col items-center gap-4 text-pc-texto-h uppercase text-lg font-bold text-center">
                        <img src="{{ asset('img/bicicleta.png') }}" alt="" class="h-12">
                        <h2 class="">Pedalea Comodoro</h2>
                    </div>

                    {{-- BOTONES DEL SIDEBAR --}}
                    @yield('botones_sidebar')

                </div>
                {{-- LOGOUT --}}
                <div class="p-8 place-self-center">
                    <ul>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="text-center text-base py-2 px-4 text-pc-texto-h font-medium rounded-full bg-gray-200 hover:bg-white hover:shadow-md my-1">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </aside>
        </div>

        {{-- * Para vista sm (MOBILE) * --}}
        {{-- NAVBAR INFERIOR --}}
        <div>
            <nav class="bg-gray-50 fixed bottom-0 left-0 w-screen h-20 md:hidden shadow-[0_-2px_4px_0_rgba(0,0,0,0.05)]"
                x-transition:enter="transition-transform transform duration-500"
                x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition-transform transform duration-500"
                x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">

                {{-- BOTONES DEL NAV MOBILE --}}
                <div class="h-full px-8 flex justify-between items-center text-sm">
                    @yield('botones_mobile')
                </div>
            </nav>
        </div>
    </div>

    {{-- CONTENIDO PRINCIPAL --}}
    <main id="main" class="flex flex-col mt-14 p-8 gap-8  lg:ml-64 overflow-y-auto">
        @yield('contenido')
    </main>

    @yield('scripts')
</body>

</html>
