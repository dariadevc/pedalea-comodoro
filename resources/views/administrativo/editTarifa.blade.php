@extends('layouts.administrativo')

@section('contenido')
    <div class="w-full max-w-lg mx-auto bg-gray-50 shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold text-pc-texto-h mb-4">Modificar Tarifa</h1>

        <form action="{{ route('administrativo.updateTarifa') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            @if (session('error'))
                <div class="p-4 bg-red-100 text-red-600 rounded-md shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div>
                <label for="monto" class="block text-pc-texto-h font-semibold mb-2">Monto:</label>
                <input type="number" name="monto" id="monto"
                    value="{{ $monto_tarifa }}"
                    class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-pc-rojo focus:border-pc-rojo"
                    required>

            </div>

            <div>
                <label class="block text-pc-texto-h font-semibold mb-2">Ultima fecha de modificación:</label>
                <p class="w-full border border-gray-300 rounded-md py-2 px-3 bg-gray-100 text-pc-texto-h">
                    {{ $ultima_fecha_modificacion_tarifa }}
                </p>
            </div>

            <div class="flex justify-between items-center mt-6">
                <button type="submit"
                    class="bg-pc-rojo hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-md shadow">
                    Actualizar
                </button>
                <a href="{{ route('inicio') }}" class="text-pc-texto-h hover:text-gray-700 font-medium">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection
