@extends('layouts.cliente')

@section('titulo', 'Pedalea Comodoro | Devolver')
@section('nombre_seccion', 'Devolver')

@section('contenido')
    @include('cliente.partials.devolver.consulta-danios')
    <div id="contenedorFormularioDanios"></div>
    <div id="contenedorCalificarEstaciones"></div>
    <div id="contenedorDevolucion"></div>
    
@endsection

@section('scripts')
    @vite('resources/js/devolucion.js')
@endsection
