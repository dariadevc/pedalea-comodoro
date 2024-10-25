@extends('layouts.app')

@section('content')
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
    <div class="container mx-auto mt-6">
        <h1 class="text-2xl font-bold mb-4 text-white">Realizar infracciones</h1>
    </div>
@endsection
