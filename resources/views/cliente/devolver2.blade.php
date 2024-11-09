@extends('layouts.cliente')

@section('titulo', 'Pedalea Comodoro | Devolver')
@section('nombre_seccion', 'Devolver')

@section('contenido')
    @include('cliente.partials.consulta-danios')
    <div id="contenedorFormularioDanios"></div>
    
@endsection

@section('scripts')
    @vite('resources/js/devolucion2.js')
@endsection
