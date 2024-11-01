@extends('layouts.app')

{{-- TODO: El nombre de la sección tiene que cambiar según el parcial que se muestre en el main --}}
@section('nombre_seccion', 'Inicio')

@section('botones_sidebar')
    {{-- TODO: Que cambie el color de fondo del enlace seleccionado --}}
    {{-- TODO: El botón de inicio sigue recargando la página, cuando no debería hacer eso!! --}}
    {{-- USUARIO --}}
    <div class="text-sm">
        <ul>
            <x-item-sidebar href="{{ route('inicio_cliente') }}" @click="open = false"
                class="nav-link @if (Request::routeIs('inicio_cliente')) bg-pc-rojo text-white font-bold hover:bg-transparent hover:text-current @endif">Inicio</x-item-sidebar>
            <x-item-sidebar href="{{ route('perfil') }}" @click="open = false"
                class="nav-link @if (Request::routeIs('perfil')) bg-pc-rojo text-white font-bold hover:bg-transparent hover:text-current @endif">Perfil</x-item-sidebar>
            <x-item-sidebar href="{{ route('cargar-saldo.index') }}" @click="open = false"
                class="nav-link @if (Request::routeIs('cargar-saldo.index')) bg-pc-rojo text-white font-bold hover:bg-transparent hover:text-current @endif">Cargar
                Saldo</x-item-sidebar>
        </ul>
    </div>
    <hr>
    {{-- SECCIONES --}}
    <div class="text-sm">
        <p class="text-pc-rojo mt-2">Reservas y Alquileres</p>
        <ul>
            <x-item-sidebar href="{{ route('ver_estaciones') }}"
                class="nav-link @if (Request::routeIs('ver_estaciones')) bg-pc-rojo text-white font-bold hover:bg-transparent hover:text-current @endif"
                @click="open = false">Ver
                Estaciones</x-item-sidebar>
            <x-item-sidebar href="{{ route('reservar') }}"
                class="nav-link @if (Request::routeIs('reservar')) bg-pc-rojo text-white font-bold hover:bg-transparent hover:text-current @endif"
                @click="open = false">Reservar una
                Bicicleta</x-item-sidebar>
            {{-- ? Que cambie la palabra (Reserva o Alquiler) según lo que tenga, si no tiene nada, que no aparezca la opción? --}}
            <x-item-sidebar href="{{ route('reserva_actual') }}"
                class="nav-link @if (Request::routeIs('reserva_actual')) bg-pc-rojo text-white font-bold hover:bg-transparent hover:text-current @endif"
                @click="open = false">Reserva/Alquiler
                Actual</x-item-sidebar>
        </ul>
    </div>
    <hr>
    {{-- HISTORIALES --}}
    <div class="text-sm">
        <p class="text-pc-rojo mt-2">Historiales</p>
        <ul>
            <x-item-sidebar href="{{ route('mov_saldo') }}"
                class="nav-link @if (Request::routeIs('mov_saldo')) bg-pc-rojo text-white font-bold hover:bg-transparent hover:text-current @endif"
                @click="open = false">Movimientos del
                Saldo</x-item-sidebar>
            <x-item-sidebar href="{{ route('his_reservas') }}"
                class="nav-link @if (Request::routeIs('his_reservas')) bg-pc-rojo text-white font-bold hover:bg-transparent hover:text-current @endif"
                @click="open = false">Historial de
                Reservas</x-item-sidebar>
            {{-- TODO: Que el texto de esta sección se marque de rojo o tenga un puntito si tiene una multa pendiente de pago --}}
            <x-item-sidebar href="{{ route('his_multas') }}"
                class="nav-link @if (Request::routeIs('his_multas')) bg-pc-rojo text-white font-bold hover:bg-transparent hover:text-current @endif"
                @click="open = false">Historial de
                Multas</x-item-sidebar>
            <x-item-sidebar href="{{ route('his_suspensiones') }}"
                class="nav-link @if (Request::routeIs('his_suspensiones')) bg-pc-rojo text-white font-bold hover:bg-transparent hover:text-current @endif"
                @click="open = false">Historial de
                Suspensiones</x-item-sidebar>
        </ul>
    </div>
@endsection

@section('botones_mobile')
    {{-- INICIO --}}
    {{-- TODO: Cuando estas en una sección el color del fondo del icono cambia de color y la fuente pasa a bold --}}
    <a id="inicio"
        class="nav-link flex flex-col justify-center items-center gap-1 p-1 @if (Request::routeIs('inicio_cliente')) bg-pc-rojo text-white font-bold hover:bg-transparent hover:text-current @endif"
        href="{{ route('inicio_cliente') }}">
        <x-icon-casa-oscura height="30px" width="30px" />
        <p class="font-semibold text-pc-texto-p">Inicio</p>
    </a>
    {{-- RESERVAR/ALQUILAR --}}
    <a id="reservar"
        class="nav-link flex flex-col justify-center items-center gap-1 p-1 @if (Request::routeIs('inicio_cliente')) bg-pc-rojo text-white font-bold hover:bg-transparent hover:text-current @endif"
        href="{{ route('reservar') }}">
        <x-icon-bicicleta-oscura height="30px" width="30px" />
        <p class="font-semibold text-pc-texto-p ">Reservar</p>
    </a>
    {{-- ESTACIONES --}}
    <a id="estaciones"
        class="nav-link flex flex-col justify-center items-center gap-1 p-1 @if (Request::routeIs('inicio_cliente')) bg-pc-rojo text-white font-bold hover:bg-transparent hover:text-current @endif"
        href="{{ route('ver_estaciones') }}">
        <x-icon-mapa-oscuro height="30px" width="30px" />
        <p class="font-semibold text-pc-texto-p">Estaciones</p>
    </a>
    {{-- MÁS OPCIONES --}}
    <a id="más"
        class="nav-link flex flex-col justify-center items-center gap-1 p-1 @if (Request::routeIs('inicio_cliente')) bg-pc-rojo text-white font-bold hover:bg-transparent hover:text-current @endif"
        href="{{ route('mas') }}">
        <x-icon-puntos-oscuros height="30px" width="30px" />
        <p class="font-semibold text-pc-texto-p">Más</p>
    </a>
@endsection


@section('contenido')
    @include('cliente.partials.inicio')
@endsection
