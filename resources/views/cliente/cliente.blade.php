@extends('layouts.app')

{{-- TODO: El nombre de la sección tiene que cambiar según el parcial que se muestre en el main --}}
@section('nombre_seccion', 'Inicio')

@section('botones_sidebar')
    {{-- USUARIO --}}
    <div class="text-sm">
        <ul>
            <x-item-sidebar href="{{ route('inicio') }}" @click="open = false">Inicio</x-item-sidebar>
            <x-item-sidebar href="{{ route('perfil') }}">Perfil</x-item-sidebar>
            <x-item-sidebar href="">Cargar Saldo</x-item-sidebar>
        </ul>
    </div>
    <hr>
    {{-- SECCIONES --}}
    <div class="text-sm">
        <p class="text-pc-rojo mt-2">Reservas y Alquileres</p>
        <ul>
            <x-item-sidebar href="">Ver Estaciones</x-item-sidebar>
            <x-item-sidebar href="{{ route('reservar') }}">Reservar una Bicicleta</x-item-sidebar>
            {{-- ? Que cambie la palabra (Reserva o Alquiler) según lo que tenga, si no tiene nada, que no aparezca la opción? --}}
            <x-item-sidebar href="">Reserva/Alquiler Actual</x-item-sidebar>
        </ul>
    </div>
    <hr>
    {{-- HISTORIALES --}}
    <div class="text-sm">
        <p class="text-pc-rojo mt-2">Historiales</p>
        <ul>
            <x-item-sidebar href="">Movimientos del Saldo</x-item-sidebar>
            <x-item-sidebar href="">Historial de Reservas</x-item-sidebar>
            {{-- TODO: Que el texto de esta sección se marque de rojo o tenga un puntito si tiene una multa pendiente de pago --}}
            <x-item-sidebar href="">Historial de Multas</x-item-sidebar>
            <x-item-sidebar href="">Historial de Suspensiones</x-item-sidebar>
            <li></li>
        </ul>
    </div>
@endsection

@section('botones_mobile')
    {{-- INICIO --}}
    {{-- TODO: Cuando estas en una sección el color del fondo del icono cambia de color y la fuente pasa a bold --}}
    <button class="flex flex-col justify-center items-center gap-1 p-1">
        <x-icon-casa-oscura height="30px" width="30px" />
        <p class="font-semibold text-pc-texto-p">Inicio</p>
    </button>
    {{-- RESERVAR/ALQUILAR --}}
    <button class="flex flex-col justify-center items-center gap-1 p-1">
        <x-icon-bicicleta-oscura height="30px" width="30px" />
        <p class="font-semibold text-pc-texto-p">Reservar</p>
    </button>
    {{-- ESTACIONES --}}
    <button class="flex flex-col justify-center items-center gap-1 p-1">
        <x-icon-mapa-oscuro height="30px" width="30px" />
        <p class="font-semibold text-pc-texto-p">Estaciones</p>
    </button>
    {{-- ESTACIONES --}}
    <button class="flex flex-col justify-center items-center gap-1 p-1">
        <x-icon-puntos-oscuros height="30px" width="30px" />
        <p class="font-semibold text-pc-texto-p">Más</p>
    </button>
@endsection

{{-- TODO: Que el contenido cambie según la sección en que se encuentra --}}
@section('contenido')
    @include('cliente.partials.inicio')
@endsection
