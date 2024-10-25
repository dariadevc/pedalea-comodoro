@extends('layouts.inspector')

@section('titulo', 'Dehabilitar Bicicletas')

@section('nombre_seccion', 'Inicio')

@section('content')
    <div>
        <h1 class="text-2xl font-bold mb-6 text-white">Lista de Bicicletas del Inspector</h1>
        <button >

        </button>
    </div>

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

    <form action="{{ route('bicicletas.deshabilitar') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="patente" class="block text-lg font-semibold mb-2 text-gray-700">Ingrese la patente de la bicicleta</label>
            <input type="text" name="patente" id="patente"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Ej: A05" required>
        </div>

        <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Deshabilitar Bicicleta
        </button>
    </form>
@endsection
