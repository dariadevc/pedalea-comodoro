@extends('layouts.app')
@section('content')
    <h1 class="text-2xl font-bold mb-6 bg-white">Panel Inspector</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold">Bicicletas</h2>
            <p class="mt-2">Deshabilitar las bicicletas.</p>
            <div class="mt-4">
                <a href="{{ route('inspector.bicicletas') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ver las bicicletas</a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold">Insfracciones</h2>
            <p class="mt-2">Generar insfracciones a clientes.</p>
            <div class="mt-4">
                <a href="{{ route('inspector.infraccion') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Generar una Infracción</a>
            </div>
        </div>
    </div>
@endsection
