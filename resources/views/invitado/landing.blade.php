@extends('layouts.invitado')

@section('titulo', 'Pedalea Comodoro')

@section('header')
    <div class="container flex flex-1 justify-between items-center">
        <a href="{{ route('landing') }}" class="px-2">
            <div class="py-1 flex items-center gap-4 text-slate-50 uppercase text-sm font-semibold">
                <img src="{{ asset('img/bicicleta_blanca.png') }}" alt="" class="h-14">
                <h2 class="">Pedalea Comodoro</h2>
            </div>
        </a>
        <div class="flex justify-end items-center text-nowrap gap-6">
            <ul class="hidden sm:flex flex-1 justify-end items-center gap-10 text-slate-50 uppercase text-sm font-semibold">
                @if (!Auth::user())
                    <a href="{{ route('iniciar-sesion') }}"
                        class="btn bg-slate-50 text-pc-rojo rounded-full px-6 py-3 uppercase hover:bg-pc-rojo hover:text-slate-50 hover:outline hover:outline-4 hover:-outline-offset-4 hover: outline-slate-50">Iniciar
                        Sesión</a>
                @endif

                {{-- Si inició sesión le va a permitir cerrar sesión --}}
                @if (Auth::user())
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="btn bg-slate-50 text-pc-rojo rounded-full px-6 py-3 uppercase hover:bg-pc-rojo hover:text-slate-50 hover:outline hover:outline-4 hover:-outline-offset-4 hover:outline-slate-50">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                @endif

            </ul>
            <div class="flex flex-1 justify-end">
                <div x-data="{ open: false }">
                    <button @click="open = ! open">
                        <x-icon-hmenu-claro height="30px" width="30px" />
                    </button>
                    <nav x-show=open @click.away="open = false" class="absolute top-full left-0 w-full bg-pc-rojo py-4">
                        <ul
                            class="flex flex-col justify-end items-center gap-1 text-slate-50 uppercase text-sm font-semibold text-center">
                            <li>
                                <a href="#introduccion" @click="open = false"
                                    class="block w-full py-2 px-8 m-2 hover:border-b-2 hover:border-white">Inicio</a>
                            </li>
                            <li>
                                <a href="#estadisticas" @click="open = false"
                                    class="block w-full py-2 px-8 m-2 hover:border-b-2 hover:border-white">Estadísticas</a>
                            </li>
                            <li>
                                <a href="#como-funciona" @click="open = false"
                                    class="block w-full py-2 px-8 m-2 hover:border-b-2 hover:border-white">¿Cómo
                                    funciona?</a>
                            </li>
                            <li>
                                <a href="#tarifa" @click="open = false"
                                    class="block w-full py-2 px-8 m-2 hover:border-b-2 hover:border-white">Tarifa</a>
                            </li>
                            <li><a href="#mapa" @click="open = false"
                                    class="block w-full py-2 px-8 m-2 hover:border-b-2 hover:border-white">Estaciones</a>
                            </li>
                            <!-- BOTÓN -->
                            {{-- ? ¿No queda centrado o es mi imaginación? --}}
                            @if (!Auth::user())
                                <a href="{{ route('iniciar-sesion') }}"
                                    class="btn bg-slate-50 text-pc-rojo rounded-full px-6 py-3 mt-5 uppercase hover:bg-pc-rojo hover:text-slate-50 hover:outline hover:outline-4 hover:-outline-offset-4 hover: outline-slate-50 sm:hidden">Iniciar
                                    Sesión</a>
                            @endif

                            {{-- Si inicio sesión le va a permitir cerrar sesión --}}
                            @if (Auth::user())
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="btn bg-slate-50 text-pc-rojo rounded-full px-6 py-3 mt-5 uppercase hover:bg-pc-rojo hover:text-slate-50 hover:outline hover:outline-4 hover:-outline-offset-4 hover:outline-slate-50 sm:hidden">
                                        {{ __('Log Out') }}
                                    </button>
                                </form>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- TODO: Agregar sección para acceder al manual de usuario --}}
@section('contenido')
    <!-- INTRODUCCIÓN -->
    <section id="introduccion" class="relative scroll-mt-28">
        <div class="container flex flex-col-reverse lg:flex-row items-center gap-1 my-12 lg:gap-20 mt-16">
            <!-- CONTENIDO -->
            <div class="flex flex-1 flex-col items-center lg:items-start">
                <h1 class="text-pc-texto-h text-4xl lg:text-6xl text-center lg:text-left my-6 font-bold">
                    Pedalea Comodoro
                </h1>
                <p class="text-pc-texto-p text-lg text-center lg:text-left mb-6">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse lobortis volutpat turpis, ac
                    elementum massa finibus vel. Mauris sollicitudin porta venenatis. Sed tincidunt sollicitudin tincidunt.
                    Integer eu urna nisi. Nam in luctus ante. Donec rutrum vestibulum blandit. Fusce egestas nisi arcu, eu
                    varius ex vulputate id. Proin elementum eros nec nunc egestas, at elementum ex posuere.
                </p>

                <!-- BOTONES -->
                <div class="flex justify-center flex-wrap gap-6">
                    @if (!Auth::user())
                        <a href="{{ route('registrarse') }}">
                            <x-btn-azul-blanco>{{ 'Registrarse' }}</x-btn-azul-blanco>
                        </a>

                        <a href="{{ route('iniciar-sesion') }}">
                            <x-btn-rojo-blanco>{{ 'Iniciar Sesión' }}</x-btn-rojo-blanco>
                        </a>
                    @endif
                </div>
            </div>
            <!-- IMÁGEN -->
            <div class="flex justify-center flex-1 mb-0">
                <img src="{{ asset('img/bicicletas-ejemplo1.jpg') }}" alt="" class="max-h-80 lg: h-90">
            </div>
        </div>
    </section>

    <!-- ESTADÍSTICAS -->
    <section id="estadisticas" class="relative scroll-mt-28">
        <div class="bg-pc-azul w-full h-auto py-10 sm:px-10 my-12 mt-20">
            <div class="container grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-12">
                <!-- CONTENIDO -->
                <div class="text-center content-center col-span-2 md:col-span-4 lg:col-span-1">
                    <h3 class="text-slate-50 uppercase font-semibold tracking-widest text-xl">Estadísticas</h3>
                </div>
                <div class="text-center">
                    <p class="text-slate-50 text-3xl sm:text-4xl font-semibold">20</p>
                    <h4 class="text-slate-50">Estaciones</h4>
                </div>
                <div class="text-center">
                    <p class="text-slate-50 text-3xl sm:text-4xl font-semibold">400</p>
                    <h4 class="text-slate-50">Bicicletas</h4>
                </div>
                <div class="text-center">
                    <p class="text-slate-50 text-3xl sm:text-4xl font-semibold">500</p>
                    <h4 class="text-slate-50">Usuarios</h4>
                </div>
                <div class="text-center">
                    <p class="text-slate-50 text-3xl sm:text-4xl font-semibold">8000</p>
                    <h4 class="text-slate-50">Viajes</h4>
                </div>
            </div>
        </div>
    </section>

    {{-- TODO: Agregar iconos a los distintos pasos --}}
    <!-- ¿CÓMO FUNCIONA -->
    <section id="como-funciona" class="relative scroll-mt-28">
        <div class="container my-12 mt-20 ">
            <!-- CONTENIDO -->
            <div class="text-center my-12">
                <h2 class="text-pc-texto-h font-bold text-3xl sm:text-4xl capitalize">¿Cómo funciona?</h2>
            </div>
            <div class="grid justify-center content-center grid-cols-1 px-12 sm:grid-cols-2 lg:grid-cols-4 gap-12">
                <div class="border-2 border-solid border-pc-rojo rounded-xl p-5 text-center shadow-md">
                    <p>icono</p>
                    <p class="font-semibold text-xl">1</p>
                    <h4 class="font-semibold text-xl mb-5">Registrate,</h4>
                    <p>completando los datos necesarios</p>
                </div>
                <div class="border-2 border-solid border-pc-azul rounded-xl p-5 text-center shadow-md">
                    <p>icono</p>
                    <p class="font-semibold text-xl">2</p>
                    <h4 class="font-semibold text-xl mb-5 under">Cargá saldo,</h4>
                    <p>para pagar las reservas y los alquileres</p>
                </div>
                <div class="border-2 border-solid border-pc-rojo rounded-xl p-5 text-center shadow-md">
                    <p>icono</p>
                    <p class="font-semibold text-xl">3</p>
                    <h4 class="font-semibold text-xl mb-5 under">Reservá una bicicleta,</h4>
                    <p>indicando el tiempo de uso</p>
                </div>
                <div class="border-2 border-solid border-pc-azul rounded-xl p-5 text-center shadow-md">
                    <p>icono</p>
                    <p class="font-semibold text-xl">4</p>
                    <h4 class="font-semibold text-xl mb-5 under">Retirá tu bicicleta,</h4>
                    <p>de tu estación de preferencia</p>
                </div>
            </div>
        </div>
    </section>

    {{-- TARIFA --}}
    <section id="tarifa" class="relative scroll-mt-28">
        <div class="container flex flex-col lg:flex-row items-center gap-1 my-12 lg:gap-20 mt-20">
            <!-- IMÁGEN -->
            <div class="flex justify-center flex-1 mb-0">
                <img src="{{ asset('img/bicicletas-ejemplo1.jpg') }}" alt="" class="max-h-80 lg: h-96">
            </div>
            <!-- CONTENIDO -->
            <div class="flex flex-1 flex-col items-center">
                <h2 class="text-pc-texto-h font-bold text-3xl sm:text-4xl capitalize text-center lg:text-right my-6">Tarifa
                </h2>
                <p class="text-pc-texto-p text-lg text-center lg:text-right mb-6">
                    Por una hora de alquiler:
                </p>
                <div class="border-2 border-solid border-pc-rojo rounded-xl p-5 mx-12 max-w-96 text-center shadow-md">
                    <h4 class="font-bold text-3xl p-5">$1000</h4>
                </div>
            </div>
        </div>
    </section>

    {{-- TODO: Agregar mapa real! --}}
    <!-- MAPA INTERACTIVO  -->
    <section id="seccion-mapa" class="relative scroll-mt-28">
        <div class="container my-12 mt-20">
            <!-- CONTENIDO -->
            <div class="text-center my-12">
                <h2 class="text-pc-texto-h font-bold text-3xl sm:text-4xl capitalize my-6">Estaciones en la ciudad</h2>
                <p class="text-pc-texto-p">En este mapa interactivo podes encontrar todas las estaciones que se encuentran
                    en la ciudad de Comodoro Rivadavia.</p>
                <p class="text-pc-texto-p">Podes hacer click en cada punto del mapa para acceder a la información
                    disponible
                    de cada estación.</p>
            </div>
            <!-- Contenedor para el mapa interactivo -->
            <div class="flex justify-center flex-1 mb-0 z-0" id="mapa" style="width: 100%; height: 500px;"></div>
        </div>
    </section>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

    <script src="{{ asset('js/mapa.js') }}"></script>


    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);

                // Desplazamiento suave
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
@endsection
