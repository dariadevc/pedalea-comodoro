{{-- views/cliente/ver-mapa.blade --}}
@extends('layouts.cliente')

@section('nombre_seccion', 'Estaciones')

@section('contenido')
    <div class="flex flex-col space-y-4 p-6 bg-white shadow-md rounded-lg mx-auto w-full max-w-screen-lg">
        <h2 class="text-2xl font-semibold text-gray-800">Mapa de estaciones</h2>
        <div
            class="w-full md:w-3/4 lg:w-2/3 h-[600px] mx-auto rounded-lg overflow-hidden shadow-lg border border-gray-200 z-0">
            @include('estaciones.partials.mapa-estaciones', ['estaciones' => $estaciones])
        </div>
    </div>
@endsection

@section('scripts')
@endsection
