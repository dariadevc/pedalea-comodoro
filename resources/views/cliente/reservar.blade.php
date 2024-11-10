@extends('layouts.cliente')

@section('nombre_seccion', 'Reservar')

@section('contenido')
    <div id="contenedor-pasos">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </div>
@endsection

@section('scripts')
    @vite('resources/js/reservar.js')
    @vite('resources/js/cargar-saldo.js')
    <script>
        var urlPasos = "{{ route('reservar.pasos') }}"
        var urlCargarSaldoModal = "{{ route('cargar-saldo.mostrar-modal') }}";
    </script>
@endsection
