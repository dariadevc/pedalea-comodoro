@extends('layouts.cliente')

@section('titulo', 'Pedalea Comodoro | Reservar')

@section('nombre_seccion', 'Reservar')

@section('contenido')
<div id="contenedor-pasos">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</div>



@endsection

@section('scripts')
    @vite('resources/js/reservar.js')
    <script>
        var urlPasos = "{{ route('reservar.pasos') }}"
    </script>
@endsection
