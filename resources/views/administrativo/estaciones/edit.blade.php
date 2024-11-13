@extends('layouts.administrativo')

@section('contenido')
    <div class="w-full max-w-lg mx-auto bg-gray-50 shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold text-pc-texto-h mb-4">Editar Estación</h1>

        <form action="{{ route('estaciones.update', $estacion->id_estacion) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- @if (session('error'))
                <div class="p-4 bg-red-100 text-red-600 rounded-md shadow-sm">
                    {{ session('error') }}
                </div>
            @endif --}}

            <div>
                <label for="estado" class="block text-pc-texto-h font-semibold mb-2">Estado:</label>
                <select id="estado" name="estado"
                    class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-pc-rojo focus:border-pc-rojo"
                    required>
                    @foreach ($estados as $estado)
                        <option value="{{ $estado->id_estado }}"
                            {{ $estacion->id_estado == $estado->id_estado ? 'selected' : '' }}>{{ $estado->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('estado')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nombre" class="block text-pc-texto-h font-semibold mb-2">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="{{ $estacion->nombre }}"
                    class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-pc-rojo focus:border-pc-rojo">
                @error('nombre')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="latitud" class="block text-pc-texto-h font-semibold mb-2">Latitud:</label>
                <input type="number" name="latitud" id="latitud" value="{{ $estacion->latitud }}" step="0.000001"
                    min="-90" max="90"
                    class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-pc-rojo focus:border-pc-rojo">
                @error('latitud')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="longitud" class="block text-pc-texto-h font-semibold mb-2">Longitud:</label>
                <input type="number" name="longitud" id="longitud" value="{{ $estacion->longitud }}" step="0.000001"
                    min="-90" max="90"
                    class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-pc-rojo focus:border-pc-rojo">
                @error('longitud')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center mt-6">
                <button type="submit"
                    class="bg-pc-rojo hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-md shadow">
                    Actualizar
                </button>
                <a href="{{ route('estaciones.index') }}" class="text-pc-texto-h hover:text-gray-700 font-medium">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection
