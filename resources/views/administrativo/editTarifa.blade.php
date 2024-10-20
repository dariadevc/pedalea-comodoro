@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-6">
        <h1 class="text-2xl font-bold mb-4 text-white">Modificar Tarifa</h1>

        <form action="{{ route('administrativo.updateTarifa') }}" method="POST" class="bg-white p-6 rounded shadow-md">
            @csrf
            @method('PUT')
            
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-4">
                <label for="monto" class="block text-gray-700 font-bold mb-2">Monto:</label>
                <input type="number" name="monto" id="monto" value="{{ $tarifa->where('clave', 'tarifa')->first()->valor }}" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Fecha de Modificación:</label>
                <p class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    {{ $tarifa->where('clave', 'fecha_modificacion_tarifa')->first()->valor }}
                </p>
            </div>
            

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Actualizar</button>
                <a href="{{ route('administrativo.dashboard') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
