@extends('layouts.cliente')

@section('nombre_seccion', 'Inicio')

@section('contenido')
    <div class="flex flex-col gap-6 w-full md:w-1/2 ">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="flex flex-col justify-center items-center gap-4">
            {{-- BIENVENIDA --}}
            <div class="flex flex-col md:flex-row items-center gap-1 md:gap-4">
                <!-- CAMBIAR LOGO POR LA VERSIÓN FINAL -->

                <img src="img/bicicleta.png" alt="" class="h-14 w-14">
                <p class="text-xl font-semibold text-pc-texto-h">¡Hola, <span
                        class="font-extrabold text-2xl text-pc-rojo">{{ $datos['nombre'] . ' ' . $datos['apellido'] }}</span>!
                </p>
            </div>

            <div class="flex gap-4 w-full xl:w-3/4">
                {{-- SALDO DISPONIBLE --}}
                <div class="bg-gray-50 rounded-xl p-4 w-1/2 shadow-md text-center">
                    <h2 class="text-sm tracking-wider">Saldo
                        Disponible</h2>
                    <p class="text-2xl font-bold">${{ $datos['saldo'] }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 w-1/2 shadow-md text-center">
                    <h2 class="text-sm tracking-wider">Puntaje</h2>
                    <p class="text-2xl font-bold">{{ $datos['puntaje'] }} <span class="text-sm">pts</span></p>
                </div>
            </div>
        </div>


        {{-- TARJETA RESERVA/ALQUILER ACTUAL --}}
        {{-- * La información de esta tarjeta se actualiza, si no tiene reserva lo va a mandar a reservar, si tiene reserva en curso muestra algunos datos y te manda a consultar reserva, si tiene alquiler en curso muestra algunos datos y te manda a consultar alquiler * --}}

        {{-- TODO: Actualizar la tarjeta si el usuario tiene alguna reserva o alquiler en curso, reserva = rojo, alquiler = azul --}}
        @if ($estado == 'Finalizada')
            <div class="bg-gradient-to-br from-pc-naranja to-pc-rojo w-full p-4 shadow-md rounded-xl flex flex-col">
                <h2
                    class="text-sm text-left uppercase font-semibold text-slate-50 tracking-wider border-b-2 border-slate-50">
                    Reserva
                </h2>
                <p class="mt-4 text-left text-slate-50">No te olvides de...</p>
                <button class="mt-6 text-center">
                    <a href="{{ route('reservar') }}"
                        class="py-2 px-4 rounded-full font-semibold bg-slate-50 shadow-sm">Reservar tu
                        bicicleta</a>
                </button>
            </div>
        @elseif ($estado == 'Activa' || $estado == 'Modificada')
            <div class="bg-gradient-to-br from-pc-naranja to-pc-rojo w-full p-4 shadow-md rounded-xl flex flex-col">
                <h2
                    class="text-sm text-left uppercase font-semibold text-slate-50 tracking-wider border-b-2 border-slate-50">
                    Reserva
                </h2>
                <p class="mt-4 text-left text-slate-50">Retirá tu bicicleta en la estación <span
                        class="font-semibold">{{ $reserva['estacion_retiro_nombre'] }}</span> desde las
                    <span class="font-semibold">{{ $hora_retiro_reserva_15_menos }}hs</span> hasta las 
                    <span class="font-semibold">{{ $hora_retiro_reserva_15_mas }}hs</span>.
                </p>
                <p class="mt-4 text-left text-slate-50 text-sm">Para <span class="font-semibold">alquilar</span>, clickea en
                    el botón de abajo.</p>
                <button class="mt-3 text-center">
                    <a href="{{ route('reserva_actual') }}"
                        class="py-2 px-4 rounded-full font-semibold bg-slate-50 shadow-sm">Ver
                        Reserva Actual</a>
                </button>
            </div>
        @else
            <div class="bg-gradient-to-br from-pc-celeste to-pc-azul w-full p-4 shadow-md rounded-xl flex flex-col">
                <h2
                    class="text-sm text-left uppercase font-semibold text-slate-50 tracking-wider border-b-2 border-slate-50">
                    Alquiler
                </h2>
                <p class="mt-4 text-left text-slate-50">Devolvé tu bicicleta en la estación <span
                        class="font-semibold">{{ $reserva['estacion_devolucion_nombre'] }}</span>, tenes tiempo hasta las
                    <span class="font-semibold">{{ $hora_devolucion_reserva_15_mas }}hs</span>.
                </p>
                <p class="mt-4 text-left text-slate-50 text-sm">Para <span class="font-semibold">devolver</span>, clickea en
                    el botón de abajo.</p>
                <button class="mt-3 text-center">
                    <a href="{{ route('alquiler_actual') }}"
                        class="py-2 px-4 rounded-full font-semibold bg-slate-50 shadow-sm">Ver
                        Alquiler Actual</a>
                </button>
            </div>
        @endif



    </div>

    {{-- TODO: Que se cargue la actividad reciente --}}
    <div class="grid auto-rows-max gap-2 bg-gray-50 rounded-xl shadow-md w-full md:w-1/2 md:place-self-start">
        {{-- SUBTÍTULO --}}
        <div class="border-b-2 w-full p-4">
            <h2 class="font-semibold text-pc-texto-h">Actividad Reciente</h2>
        </div>
        {{-- LISTA DE ACTIVIDADES --}}
        {{-- TODO: Actualizar tarjetas a medida que realiza nuevas reservas, cada href vincula a la reserva/alquiler correspondiente --}}
        <ul class="">
            <li class="flex box-border">
                <a href="#" class="p-4 hover:bg-gray-100 w-full">
                    {{-- INFO DE LA ACTIVIDAD --}}
                    <div class="flex flex-col gap-1 items-start">
                        <p>Aún no realizaste ninguna reserva.</p>
                    </div>
                </a>
            </li>
        </ul>
        <a href="{{ route('actividad') }}" class="px-4 py-2 border-t-2 text-pc-azul hover:text-pc-rojo hover:shadow-inner">
            <div class="flex items-center justify-between">
                <p>Ver toda tu actividad</p>
                <x-icon-flecha-der-oscura width=30px height=30px />
            </div>
        </a>
    </div>
@endsection
