@extends('layouts.cliente')

@section('nombre_seccion', 'Alquiler Actual')

@section('contenido')

    <div class="w-full flex flex-col md:flex-row gap-6 justify-center items-center">
        {{-- MOSTRAR DATOS DE RESERVA --}}
        <div class="flex flex-col gap-4 w-3/4 lg:w-1/2">
            <div class="">
                <p class="text-pc-texto-p text-base border-l-4 border-l-pc-azul pl-2">Datos de tu reserva</p>
            </div>
            <div class="bg-gradient-to-br from-pc-celeste to-pc-azul p-4 shadow-md rounded-xl flex flex-col gap-6 w-full">
                <div class="rounded-xl bg-gray-50 p-4 shadow-md flex flex-col gap-3">
                    <div class="flex flex-col gap-1">
                        <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-azul self-start">Estación de
                            Retiro</h3>
                        <p class="pl-4 text-lg">{{ $reserva_ajena['estacion_retiro_nombre'] }}</p>
                    </div>
                    <div class="flex flex-col gap-1">
                        <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-azul self-start">Estación de
                            Devolución</h3>
                        <p class="pl-4 text-lg">{{ $reserva_ajena['estacion_devolucion_nombre'] }}</p>
                    </div>
                    <div class="flex flex-col gap-1">
                        <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-azul self-start">Horas de
                            Alquiler</h3>
                        <p class="pl-4 text-lg">{{ $reserva_ajena['tiempo_uso'] }}hs</p>
                    </div>
                    <div class="flex flex-col gap-1">
                        <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-azul self-start">Horario de
                            Retiro</h3>
                        <p class="pl-4 text-lg">{{ $reserva_ajena['fecha_hora_retiro'] }}hs</p>
                    </div>
                    <div class="flex flex-col gap-1">
                        <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-azul self-start">Horario de
                            Devolución</h3>
                        <p class="pl-4 text-lg">{{ $reserva_ajena['fecha_hora_devolucion'] }}hs</p>
                    </div>
                    <div class="flex flex-col gap-1">
                        <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-azul self-start">Bicicleta
                            Asignada</h3>
                        <p class="pl-4 text-lg">{{ $reserva_ajena['bicicleta_patente'] }}</p>
                    </div>
                    <div class="flex flex-col gap-1">
                        <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-azul self-start">Cliente Alquilo</h3>
                        <p class="pl-4 text-lg">{{ $usuario_reservo->nombre . ' ' . $usuario_reservo->apellido }}</p>
                    </div>
                    @if ($estado_reserva_ajena == 'Reasignada')
                        @include('cliente.partials.usuario_devuelve_reasignar', [
                            'usuario_devuelve' => $usuario_devuelve,
                        ])
                    @endif
                </div>
            </div>
        </div>

        {{-- OPCIONES A PARTIR DE LA RESERVA --}}


        <div id="contenedor_botones" class="flex flex-col gap-4 justify-center">
            <a href="{{ route('devolver.ajeno.index') }}"
                class="shadow-md py-3 px-6 rounded-full transition duration-500 font-semibold uppercase bg-slate-50 outline outline-4 -outline-offset-4 outline-pc-azul text-pc-azul hover:bg-pc-azul hover:text-slate-50 text-center">Devolver
                Bicicleta</a>
        </div>


    </div>
@endsection
