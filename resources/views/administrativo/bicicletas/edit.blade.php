@extends('layouts.administrativo')

@section('contenido')
    <div class="w-full max-w-lg mx-auto bg-gray-50 shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold text-pc-texto-h mb-4">Editar Bicicleta</h1>

        <form action="{{ route('bicicletas.update', $bicicleta->id_bicicleta) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            @if (session('error'))
                <div class="p-4 bg-red-100 text-red-600 rounded-md shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div>
                <label for="patente" class="block text-pc-texto-h font-semibold mb-2">Patente:</label>
                <p id="patente" class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none bg-gray-200">{{ $bicicleta->patente }}</p>
            </div>

            <div>
                <label for="estado" class="block text-pc-texto-h font-semibold mb-2">Estado:</label>
                <select id="estado" name="estado"
                    class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-pc-rojo focus:border-pc-rojo"
                    required>
                    @foreach ($estados as $estado)
                        <option value="{{ $estado->id_estado }}"
                            {{ $bicicleta->id_estado == $estado->id_estado ? 'selected' : '' }}>{{ $estado->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="estacion" class="block text-pc-texto-h font-semibold mb-2">Estación Actual:</label>
                <select id="estacion" name="estacion"
                    class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-pc-rojo focus:border-pc-rojo"
                    required>
                    <option value="0" {{ $bicicleta->id_estacion_actual ? 'selected' : '' }}>Ninguna Estación</option>
                    @foreach ($estaciones as $estacion)
                        <option value="{{ $estacion->id_estacion }}"
                            {{ $bicicleta->id_estacion_actual == $estacion->id_estacion ? 'selected' : '' }}>
                            {{ $estacion->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-between items-center mt-6">
                <button type="submit" class="bg-pc-rojo hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-md shadow">
                    Actualizar
                </button>
                <a href="{{ route('bicicletas.index') }}" class="text-pc-texto-h hover:text-gray-700 font-medium">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection
