@extends('layouts.inspector')
@section('titulo', 'Generar Infracción')
@section('nombre_seccion', 'Infracción')
@section('contenido')
    <h1 class="text-lg text-left uppercase font-semibold text-slate-700 tracking-wider border-b-2 border-slate-700">
        Generar una infracción
    </h1>
    <form action="{{ route('infraccion.generar') }}" method="POST"
        class="bg-gradient-to-br from-pc-naranja to-pc-rojo w-full h-70 p-4 shadow-md rounded-xl flex flex-col items-center"
        enctype="multipart/form-data">
        @csrf
        <div class="mb-4 w-full">
            <!-- Campo de patente -->
            <label for="patente" class="mt-4 text-left text-slate-50 border-b-2 border-slate-50">
                Ingrese la patente de la bicicleta
            </label>
            <br>
            <input type="text" name="patente" id="patente"
                class="w-full mt-4 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 bg-gray-50 border-b-2 text-pc-texto-p"
                placeholder="Ej: A05" required>
            <br>
            <label for="puntos" class="mt-4 text-left text-slate-50 border-b-2 border-slate-50">
                Ingrese la cantidad de puntos que le restan
            </label>
            <br>
            <input type="number" name="puntos" id="puntos" min="1" step="1"
                class="w-full mt-4 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 bg-gray-50 border-b-2 text-pc-texto-p"
                placeholder="Ej: 5" required>
            <!-- Campo de motivo como textarea -->
            <label for="motivo" class="mt-4 text-left text-slate-50 border-b-2 border-slate-50">
                Ingrese el motivo por la cual realiza la infracción
            </label>
            <br>
            <textarea name="motivo" id="motivo" rows="5"
                class="w-full mt-4 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 bg-gray-50 border-b-2 text-pc-texto-p resize-none"
                placeholder="Ingrese el motivo..." required></textarea>
        </div>

        <!-- Mensajes de éxito o error -->
        @if (session('success'))
            <div class="alert alert-success mb-4 text-white">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger text-white">
                {{ session('error') }}
            </div>
        @endif

        <!-- Botones -->
        <div class="mt-6 flex space-x-4">
            <button type="submit" class="py-2 px-4 rounded-full font-semibold bg-slate-50 shadow-sm">
                Generar infracción
            </button>
            <button type="button" onclick="window.location.href='{{ route('inspector.inicio') }}';"
                class="py-2 px-4 rounded-full font-semibold bg-gray-50 shadow-sm">
                Volver al inicio
            </button>
        </div>
    </form>
@endsection
