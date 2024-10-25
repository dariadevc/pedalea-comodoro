@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6 text-white">Lista de Bicicletas del Inspector</h1>

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

    <p class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mb-4">Deshabilita una Bicicleta</p>

    
@endsection
