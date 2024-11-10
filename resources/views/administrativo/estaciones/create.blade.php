@extends('layouts.app-blade')

@section('content')
    <div class="container mx-auto mt-6">
        <h1 class="text-2xl font-bold mb-4 text-white">Crear Nueva Estacion</h1>

        <form action="{{ route('estaciones.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
            @csrf

            <div class="mb-4">
                <label for="id" class="block text-gray-700 font-bold mb-2">ID:</label>
                <input type="text" id="id" name="id" value="{{ old('id') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" disabled>
            </div>

            <div class="mb-4">
                <label for="estado" class="block text-gray-700 font-bold mb-2">Estado:</label>
                <select id="estado" name="estado" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    @foreach ($estados as $estado)
                        <option value="{{ $estado->id_estado }}" {{ $estado->id_estado == 1 ? 'selected' : '' }}>{{ $estado->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="nombre" class="block text-gray-700 font-bold mb-2">Nombre:</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="latitud" class="block text-gray-700 font-bold mb-2">Latitud:</label>
                <input type="number"name="latitud" id="latitud" value="{{ old('latitud') }}" step="0.000001" min="-90" max="90" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="longitud" class="block text-gray-700 font-bold mb-2">Longitud:</label>
                <input type="number" name="longitud" id="longitud" value="{{ old('longitud') }}" step="0.000001" min="-180" max="180" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>


            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Crear Estacion</button>
                <a href="{{ route('estaciones.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
