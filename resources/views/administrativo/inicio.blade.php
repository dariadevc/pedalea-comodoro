@extends('layouts.administrativo')

@section('nombre_seccion', 'Inicio')

@section('contenido')
    <div class="flex flex-col gap-6">
        {{-- BIENVENIDA --}}
        <div class="flex flex-col md:flex-row items-center gap-1 md:gap-4 place-self-center">
            <!-- CAMBIAR LOGO POR LA VERSIÓN FINAL -->
            <img src="img/bicicleta.png" alt="" class="h-14 w-14">
            <p class="text-xl font-semibold text-pc-texto-h">¡Hola, <span
                    class="font-extrabold text-2xl text-pc-rojo">{{ $datos['nombre'] . ' ' . $datos['apellido'] }}</span>!
            </p>
        </div>


        {{-- TARJETA RESERVA/ALQUILER ACTUAL --}}
        {{-- * La información de esta tarjeta se actualiza, si no tiene reserva lo va a mandar a reservar, si tiene reserva en curso muestra algunos datos y te manda a consultar reserva, si tiene alquiler en curso muestra algunos datos y te manda a consultar alquiler * --}}

        {{-- TODO: Actualizar la tarjeta si el usuario tiene alguna reserva o alquiler en curso, reserva = rojo, alquiler = azul --}}
        <div class="bg-gradient-to-br from-pc-naranja to-pc-rojo w-full h-40 p-4 shadow-md rounded-xl flex flex-col">
            <h2 class="text-sm text-left uppercase font-semibold text-slate-50 tracking-wider border-b-2 border-slate-50">
                Reserva
            </h2>
            <p class="mt-4 text-left text-slate-50">No te olvides de...</p>
            <button class="mt-6 text-center">
                <a href="{{ route('reservar') }}"
                    class="py-2 px-4 rounded-full font-semibold bg-slate-50 shadow-sm">Reservar tu
                    bicicleta</a>
            </button>
        </div>
        {{-- OTRAS OPCIONES --}}
        {{-- TODO: Conectar los botones a las vistas correspondientes --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold">Bicicletas</h2>
                <p class="mt-2">Gestiona las bicicletas del sistema.</p>
                <div class="mt-4">
                    <a href="{{ route('bicicletas.index') }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ver todas las bicicletas</a>
                    <a href="{{ route('bicicletas.create') }}"
                        class="ml-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Agregar bicicleta</a>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold">Estaciones</h2>
                <p class="mt-2">Gestiona las estaciones del sistema.</p>
                <div class="mt-4">
                    <a href="{{ route('estaciones.index') }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ver todas las estaciones</a>
                    <a href="{{ route('estaciones.create') }}"
                        class="ml-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Agregar estación</a>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold">Tarifa</h2>
                <p class="mt-2">Gestiona la tarifa actual del sistema.</p>
                <div class="mt-4">
                    <a href="{{ route('administrativo.editTarifa') }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ver tarifa actual</a>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold">Informes</h2>
                <p class="mt-2">Gestiona los distintos informes del sistema.</p>
                <div class="mt-4">
                    <a href="{{ route('informes.menu') }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ver informes</a>
                </div>
            </div>
        </div>
    </div>

    {{-- ACTIVIDAD RECIENTE --}}
    <div class="grid auto-rows-max gap-2 bg-gray-50 rounded-xl w-1/2 shadow-md">
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
                        <h2>Reserva</h2>
                        <p>Cancelada</p>
                    </div>
                </a>
            </li>
        </ul>
        <a href="#" class="px-4 py-2 border-t-2">
            <div class="flex items-center justify-between">
                <p>Ver toda tu actividad</p>
                <x-icon-flecha-der-oscura width=30px height=30px />
            </div>
        </a>
    </div>
@endsection
