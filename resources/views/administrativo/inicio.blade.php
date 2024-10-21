@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6 bg-white">Panel Administrativo</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold">Bicicletas</h2>
            <p class="mt-2">Gestiona las bicicletas del sistema.</p>
            <div class="mt-4">
                <a href="{{ route('bicicletas.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ver todas las bicicletas</a>
                <a href="{{ route('bicicletas.create') }}" class="ml-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Agregar bicicleta</a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold">Estaciones</h2>
            <p class="mt-2">Gestiona las estaciones del sistema.</p>
            <div class="mt-4">
                <a href="{{ route('estaciones.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ver todas las estaciones</a>
                <a href="{{ route('estaciones.create') }}" class="ml-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Agregar estación</a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold">Tarifa</h2>
            <p class="mt-2">Gestiona la tarifa actual del sistema.</p>
            <div class="mt-4">
                <a href="{{ route('administrativo.editTarifa') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ver tarifa actual</a>
            </div>
        </div>
    </div>
@endsection
