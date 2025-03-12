@extends('layouts.inspector')
@section('titulo', 'Dehabilitar Bicicletas')
@section('nombre_seccion', 'Bicicletas')
@section('contenido')
    <h1 class="text-lg text-left uppercase font-semibold text-slate-700 tracking-wider border-b-2 border-slate-700">
        Deshabilitar una bicicleta
    </h1>

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif

    <form action="{{ route('bicicletas.deshabilitar') }}" method="POST"
        class="bg-gradient-to-br from-pc-naranja to-pc-rojo w-full h-70 p-4 shadow-md rounded-xl flex flex-col items-center"
        enctype="multipart/form-data">
        @csrf

        <div class="mb-4 w-full">
            <label for="patente" class="mt-4 text-left text-slate-50 border-b-2 border-slate-50">Ingrese la patente de la
                bicicleta</label>
            <br>
            <input type="text" name="patente" id="patente"
                class="w-full mt-4 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 bg-gray-50 border-b-2 text-pc-texto-p"
                placeholder="Ej: A05" required>
        </div>
        <div class="mt-6 flex space-x-4">
            <button type="submit" class="py-2 px-4 rounded-full font-semibold bg-slate-50 shadow-sm">
                Deshabilitar Bicicleta
            </button>
            <button type="button" onclick="window.location.href='{{ route('inicio') }}';"
                class="py-2 px-4 rounded-full font-semibold bg-gray-50 shadow-sm">
                Volver al inicio
            </button>
        </div>
    </form>
@endsection
