@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-6">
        <h1 class="text-2xl font-bold mb-4 text-white">Editar Bicicleta</h1>

        <form action="{{ route('bicicletas.update', $bicicleta->id_bicicleta) }}" method="POST"
            class="bg-white p-6 rounded shadow-md">
            @csrf
            @method('PUT')
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-4">
                <label for="id" class="block text-gray-700 font-bold mb-2">ID:</label>
                <input type="text" id="id" value="{{ $bicicleta->id_bicicleta }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    disabled>
            </div>

            <div class="mb-4">
                <label for="patente" class="block text-gray-700 font-bold mb-2">Patente:</label>
                <input type="text" id="patente" value="{{ $bicicleta->patente }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    disabled>
            </div>

            <div class="mb-4">
                <label for="estado" class="block text-gray-700 font-bold mb-2">Estado:</label>
                <select id="estado" name="estado"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
                    @foreach ($estados as $estado)
                        <option value="{{ $estado->id_estado }}"
                            {{ $bicicleta->id_estado == $estado->id_estado ? 'selected' : '' }}>{{ $estado->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="estacion" class="block text-gray-700 font-bold mb-2">Estación Actual:</label>
                <select id="estacion" name="estacion"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
                    <option value="0" {{ $bicicleta->id_estacion_actual ? 'selected' : '' }}>Ninguna Estación
                    </option>
                    @foreach ($estaciones as $estacion)
                        <option value="{{ $estacion->id_estacion }}"
                            {{ $bicicleta->id_estacion_actual == $estacion->id_estacion ? 'selected' : '' }}>
                            {{ $estacion->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Actualizar</button>
                <a href="{{ route('bicicletas.index') }}"
                    class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Cancelar</a>
            </div>
        </form>
    </div>
@endsection