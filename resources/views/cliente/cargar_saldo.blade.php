@extends('layouts.cliente')

@section('nombre_seccion', 'Reservar')

@section('contenido')
    <div
        class="container bg-gray-100 flex rounded-2xl shadow-lg max-w-4xl p-8 justify-center items-center sm:items-center sm:justify-start gap-3">
        <div class="md:w-1/2 px-8 md:px-16 ">
            <h2 class="font-bold text-3xl text-pc-rojo border-b border-pc-rojo py-4">Cargar Saldo</h2>

            <form method="POST" action="{{ route('cargar-saldo.store') }}" class="flex flex-col gap-4">
                @csrf

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif
                <div class="flex flex-col gap-2">
                    <label for="monto">Monto</label>
                    <x-text-input id='monto' type="number" step="0.01" min="0" max="99999.99"
                        value="{{ old('monto') }}" placeholder="1500.00" name="monto" required autofocus
                        class="mt-8" />
                    @error('monto')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <x-btn-rojo-blanco type="submit">{{ 'Cargar' }}</x-btn-rojo-blanco>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/reservar.js')
    <script>
        var urlPasos = "{{ route('reservar.pasos') }}"
    </script>
@endsection
