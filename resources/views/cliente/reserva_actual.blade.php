@extends('layouts.cliente')

@section('nombre_seccion', 'Reserva ACtual')

@section('contenido')
    {{-- MOSTRAR DATOS DE RESERVA --}}
    <div class="flex flex-col gap-4 w-3/4 lg:w-1/2">
        <div class="">
            <p class="text-pc-texto-p text-base border-l-4 border-l-pc-rojo pl-2">Datos de tu reserva</p>
        </div>
        <div class="bg-gradient-to-br from-pc-naranja to-pc-rojo p-4 shadow-md rounded-xl w-full">
            <div class="rounded-xl bg-gray-50 p-4 shadow-md flex flex-col gap-3">
                <div class="flex flex-col gap-1">
                    <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-rojo self-start">Estación de
                        Retiro</h3>
                    <p class="pl-4 text-lg">{{ $reserva['estacion_retiro_nombre'] }}</p>
                </div>
                <div class="flex flex-col gap-1">
                    <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-rojo self-start">Estación de
                        Devolución</h3>
                    <p class="pl-4 text-lg">{{ $reserva['estacion_devolucion_nombre'] }}</p>
                </div>
                <div class="flex flex-col gap-1">
                    <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-rojo self-start">Horas de
                        Alquiler</h3>
                    <p class="pl-4 text-lg">{{ $reserva['tiempo_uso'] }}hs</p>
                </div>
                <div class="flex flex-col gap-1">
                    <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-rojo self-start">Horario de
                        Retiro</h3>
                    <p class="pl-4 text-lg">{{ $reserva['fecha_hora_retiro'] }}hs</p>
                </div>
                <div class="flex flex-col gap-1">
                    <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-rojo self-start">Horario de
                        Devolución</h3>
                    <p class="pl-4 text-lg">{{ $reserva['fecha_hora_devolucion'] }}hs</p>
                </div>
                <div class="flex flex-col gap-1">
                    <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-rojo self-start">Bicicleta
                        Asignada</h3>
                    <p class="pl-4 text-lg">{{ $reserva['bicicleta_patente'] }}</p>
                </div>
                <div class="flex flex-col gap-1">
                    <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-rojo self-start">Monto
                        Restante a Pagar</h3>
                    <p class="pl-4 text-lg">${{ $reserva['monto_restante'] }}</p>
                </div>
            </div>
        </div>
    </div>
    {{-- OPCIONES A PARTIR DE LA RESERVA --}}
    <div class="flex flex-row-reverse md:flex-col gap-4 justify-center">
        <a href="{{ route('alquilar.index') }}"
            class="shadow-md py-3 px-6 rounded-full transition duration-500 font-semibold uppercase bg-slate-50 outline outline-4 -outline-offset-4 outline-pc-azul text-pc-azul hover:bg-pc-azul hover:text-slate-50 text-center">Alquilar</a>
        <button type="button" onclick="toogleModal()"
            class="shadow-md py-3 px-6 rounded-full transition duration-500 font-semibold uppercase bg-slate-50 outline outline-4 -outline-offset-4 outline-gray-400 text-gray-400 hover:bg-gray-400 hover:text-slate-50">Cancelar
            reserva</button>
    </div>

    <div id="modalConfirmacion"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 invisible">
        <div class="bg-white p-6 rounded-lg shadow-lg w-11/12 sm:w-1/3">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">¿Estás seguro de que deseas cancelar la reserva?</h2>
            <div class="flex gap-4 justify-center">
                <form action="{{ route('reserva-actual.cancelar') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="shadow-md py-3 px-6 rounded-full transition duration-500 font-semibold uppercase bg-slate-50 outline outline-4 -outline-offset-4 outline-pc-azul text-pc-azul hover:bg-pc-azul hover:text-slate-50">
                        Cancelar reserva
                    </button>
                    <input type="hidden" name="id_reserva" value="{{ $reserva['id'] }}">
                </form>
                <button type="button" onclick="toogleModal()"
                    class="shadow-md py-3 px-6 rounded-full transition duration-500 font-semibold uppercase bg-slate-50 outline outline-4 -outline-offset-4 outline-gray-400 text-gray-400 hover:bg-gray-400 hover:text-slate-50">
                    No Cancelar reserva
                </button>
            </div>
        </div>

    @endsection

    @section('scripts')
        @vite('resources/js/cancelar.js')
    @endsection
