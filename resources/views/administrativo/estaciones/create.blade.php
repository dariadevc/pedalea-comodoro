@extends('layouts.administrativo')

@section('contenido')
    <div class="w-full max-w-lg mx-auto bg-gray-50 shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold text-pc-texto-h mb-4">Crear Nueva Estación</h1>

        <form action="{{ route('estaciones.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="estado" class="block text-pc-texto-h font-semibold mb-2">Estado:</label>
                <select id="estado" name="estado"
                    class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-pc-rojo focus:border-pc-rojo"
                    required>
                    @foreach ($estados as $estado)
                        <option value="{{ $estado->id_estado }}" {{ $estado->id_estado == 1 ? 'selected' : '' }}>
                            {{ $estado->nombre }}</option>
                    @endforeach
                </select>
                @error('estado')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nombre" class="block text-pc-texto-h font-semibold mb-2">Nombre:</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}"
                    class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-pc-rojo focus:border-pc-rojo">
                @error('nombre')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="latitud" class="block text-pc-texto-h font-semibold mb-2">Latitud:</label>
                <input type="number" name="latitud" id="latitud" value="{{ old('latitud') }}" step="0.000001"
                    min="-90" max="90"
                    class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-pc-rojo focus:border-pc-rojo">
                @error('latitud')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="longitud" class="block text-pc-texto-h font-semibold mb-2">Longitud:</label>
                <input type="number" name="longitud" id="longitud" value="{{ old('longitud') }}" step="0.000001"
                    min="-180" max="180"
                    class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-pc-rojo focus:border-pc-rojo">
                @error('longitud')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center mt-6">
                <button type="submit"
                    class="bg-pc-rojo hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-md shadow">
                    Crear Estación
                </button>
                <a href="{{ route('estaciones.index') }}" class="text-pc-texto-h hover:text-gray-700 font-medium">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection
