@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-6">
    <h3 class="text-3xl font-bold mb-4 text-center text-black title-section">Modificar Reserva</h3>
    <p>La estación seleccionada no tiene bicicletas disponibles. 
        ¿Desea modificar la reserva?</p>
    
    <div class="bg-sky-100 p-6 rounded shadow-md mb-6 text-center">
        <p><strong>Nueva Estación de Retiro:</strong> {{ $nuevaEstacion->nombre}}</p>
        <p><strong>Nueva Hora de Retiro:</strong> {{ $nuevoHoraRetiro }}</p>
        <p><strong>Nueva Bicicleta Asignada:</strong> {{ $nuevaBicicleta->patente}}</p>
    </div>
    <div class="flex gap-4 justify-center">
    <form method="POST" action="{{ route('reservar.confirmarModificacion') }}">
        @csrf
        <input type="hidden" name="id_reserva" value="{{ $reserva->id_reserva }}">
        <input type="hidden" name="id_estacion_retiro" value="{{ $nuevaEstacion->id_estacion }}">
        <input type="hidden" name="id_bicicleta" value="{{ $nuevaBicicleta->id_bicicleta}}">
        <input type="hidden" name="nuevoHorarioRetiro" value="{{ $nuevoHoraRetiro }}">
        <button type="submit" class="bg-lime-500 hover:bg-lime-700 text-white font-bold py-2 px-4 rounded">Modificar Reserva</button>
    </form>
    <form method="POST" action="{{ route('reservas.rechazarModificacion', $reserva->id_reserva) }}">
        @csrf
        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Rechazar Reserva</button>
    </form>
    </div>
</div>
@endsection

