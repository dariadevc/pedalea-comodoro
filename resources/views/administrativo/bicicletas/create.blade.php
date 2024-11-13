@extends('layouts.administrativo')

@section('contenido')
    <div class="w-full max-w-lg mx-auto bg-gray-50 shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold text-pc-texto-h mb-4">Crear Nueva Bicicleta</h1>
        <p class="text-gray-700">El sistema generará la patente automáticamente.</p>

        <form action="{{ route('bicicletas.store') }}" method="POST" class="space-y-4">
            @csrf
            @if (session('error'))
                <div class="p-4 bg-red-100 text-red-600 rounded-md shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div>
                <label for="estado" class="block text-pc-texto-h font-semibold mb-2">Estado:</label>
                <select id="estado" name="estado"
                    class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-pc-rojo focus:border-pc-rojo"
                    required>
                    @foreach ($estados as $estado)
                        <option value="{{ $estado->id_estado }}" {{ $estado->id_estado == '1' ? 'selected' : '' }}>
                            {{ $estado->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="estacion" class="block text-pc-texto-h font-semibold mb-2">Estación Actual:</label>
                <select id="estacion" name="estacion"
                    class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-pc-rojo focus:border-pc-rojo"
                    required>
                    <option value="0">Ninguna Estación</option>
                    @foreach ($estaciones as $estacion)
                        <option value="{{ $estacion->id_estacion }}">{{ $estacion->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-between items-center mt-6">
                <button type="submit" class="bg-pc-rojo hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-md shadow">
                    Crear Bicicleta
                </button>
                <a href="{{ route('bicicletas.index') }}" class="text-pc-texto-h hover:text-gray-700 font-medium">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection
