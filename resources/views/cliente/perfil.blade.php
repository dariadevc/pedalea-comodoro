@extends('layouts.cliente')

@section('nombre_seccion', 'Perfil')

@section('contenido')

@extends('layouts.app')


<!--View basica para mostrar los datos-->
@section('content')
    <div class="container">
        <h2>Perfil</h2>
        <br>
        @if($perfil)
        <h1>Datos:</h1>
            <ul>
                <li>Nombre: {{ $perfil->nombre }}</li>
                <li>Apellido: {{ $perfil->apellido }}</li>
                <li>Email: {{ $perfil->email }}</li>
                <li>Fecha de Nacimiento: {{ $perfil->fecha_nacimiento }}</li>
                <li>Puntaje Actual: {{ $perfil->puntaje }}</li>
            </ul>
        @else
            <p>No se encontraron datos del perfil.</p>
        @endif
    </div>
@endsection

@section('scripts')
@endsection
