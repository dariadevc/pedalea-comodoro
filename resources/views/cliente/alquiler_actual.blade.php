@extends('layouts.cliente')

@section('nombre_seccion', 'Alquiler Actual')

@section('contenido')
    <div x-data="{ mostrarBusqueda: false }" class="w-full flex flex-col md:flex-row gap-6 justify-center items-center">
        {{-- MOSTRAR DATOS DE RESERVA --}}
        <div class="flex flex-col gap-4 w-3/4 lg:w-1/2">
            <div class="">
                <p class="text-pc-texto-p text-sm border-l-4 border-l-pc-azul pl-2">Datos de tu reserva</p>
            </div>
            <div class="bg-gradient-to-br from-pc-celeste to-pc-azul p-4 shadow-md rounded-xl flex flex-col gap-6 w-full">
                <div class="rounded-xl bg-gray-50 p-4 shadow-md flex flex-col gap-3">
                    <div class="flex flex-col gap-1">
                        <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-azul self-start">Estación de
                            Retiro</h3>
                        <p class="pl-4 text-lg">{{ $reserva['estacion_retiro_nombre'] }}</p>
                    </div>
                    <div class="flex flex-col gap-1">
                        <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-azul self-start">Estación de
                            Devolución</h3>
                        <p class="pl-4 text-lg">{{ $reserva['estacion_devolucion_nombre'] }}</p>
                    </div>
                    <div class="flex flex-col gap-1">
                        <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-azul self-start">Horas de
                            Alquiler</h3>
                        <p class="pl-4 text-lg">{{ $reserva['tiempo_uso'] }}hs</p>
                    </div>
                    <div class="flex flex-col gap-1">
                        <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-azul self-start">Horario de
                            Retiro</h3>
                        <p class="pl-4 text-lg">{{ $reserva['fecha_hora_retiro'] }}hs</p>
                    </div>
                    <div class="flex flex-col gap-1">
                        <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-azul self-start">Horario de
                            Devolución</h3>
                        <p class="pl-4 text-lg">{{ $reserva['fecha_hora_devolucion'] }}hs</p>
                    </div>
                    <div class="flex flex-col gap-1">
                        <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-azul self-start">Bicicleta
                            Asignada</h3>
                        <p class="pl-4 text-lg">{{ $reserva['bicicleta_patente'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- OPCIONES A PARTIR DE LA RESERVA --}}
        <div class="flex flex-col gap-4 justify-center">
            <a href="{{ route('devolver') }}"
                class="shadow-md py-3 px-6 rounded-full transition duration-500 font-semibold uppercase bg-slate-50 outline outline-4 -outline-offset-4 outline-pc-azul text-pc-azul hover:bg-pc-azul hover:text-slate-50 text-center">Devolver
                Bicicleta</a>
            <button type="button" @click="mostrarBusqueda=!mostrarBusqueda"
                class="shadow-md py-3 px-6 rounded-full transition duration-500 font-semibold uppercase bg-slate-50 outline outline-4 -outline-offset-4 outline-gray-400 text-gray-400 hover:bg-gray-400 hover:text-slate-50">Reasignar
                Devolución</button>
        </div>

        <div x-show="mostrarBusqueda" class="fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="mostrarBusqueda = false"
                class="flex flex-col p-4 gap-2 bg-gray-50 border-pc-azul border-2 rounded-2xl shadow-lg w-3/4 max-w-md">
                <h2 class="font-semibold text-pc-texto-h place-self-center border-b-2 border-pc-azul p-1 text-lg">Reasignar
                    Devolución</h2>
                <p class="text-pc-texto-p">Ingrese el DNI del usuario que devolverá la bicicleta por usted.</p>
                <div class="text-center">
                    <input type="number" placeholder="DNI"
                        class="mb-2 border-gray-400 p-2 rounded-xl border w-full shadow-sm">
                    <button
                        class="shadow-sm py-3 px-6 rounded-full transition duration-500 font-semibold uppercase bg-slate-50 outline outline-4 -outline-offset-4 outline-pc-azul text-pc-azul hover:bg-pc-azul hover:text-slate-50 text-center">Buscar</button>
                </div>
                <div class="p-4 rounded-xl bg-gray-200">
                    {{-- ¿Agregarle icono de advertencia? --}}
                    <p class="text-sm text-pc-texto-p">Recuerde que usted sigue siendo el responsable de la bicicleta. Si la
                        entrega
                        se realiza
                        fuera de tiempo o
                        se registran daños, la penalización recaerá en usted.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
