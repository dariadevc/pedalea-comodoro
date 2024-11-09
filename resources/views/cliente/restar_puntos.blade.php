@extends('layouts.cliente')


@section('contenido')
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    <p>{{ Auth::user()->obtenerCliente()->puntaje }}</p>

    <form action="{{ route('restar-puntos.store') }}" method="POST">
        @csrf
        <input type="number" name="puntos" id="puntos">
        <button type="submit">Restar puntos</button>
    </form>

    <form action="{{ route('restablecer-multas-hechas') }}" method="POST">
        @csrf
        <button type="submit"> Restablecer multas hechas</button>
    </form>
@endsection
