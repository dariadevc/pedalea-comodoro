@extends('layouts.administrativo')

@section('nombre_seccion', 'Inicio')

@section('contenido')
    <div class="flex flex-col gap-6">
        <div class="flex flex-col lg:flex-row gap-2 lg:justify-around">
            {{-- BIENVENIDA --}}
            <div class="flex flex-col md:flex-row items-center gap-1 md:gap-4 place-self-center">
                <!-- CAMBIAR LOGO POR LA VERSIÓN FINAL -->
                <img src="img/bicicleta.png" alt="" class="h-14 w-14">
                <p class="text-xl font-semibold text-pc-texto-h">¡Hola, <span
                        class="font-extrabold text-2xl text-pc-rojo">{{ $datos['nombre'] . ' ' . $datos['apellido'] }}</span>!
                </p>
            </div>

            <div class="bg-gradient-to-br from-pc-naranja to-pc-rojo w-full lg:w-1/2 p-4 shadow-md rounded-xl">
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-lg font-semibold">Tarifa Actual: <span
                            class="font-bold text-pc-rojo text-xl">${{ $tarifa }}</span></h2>
                    <p class="mt-2">Gestioná la tarifa del sistema.</p>
                    <div class="mt-4 flex flex-col gap-2">
                        <a href="{{ route('administrativo.editTarifa') }}"
                            class="bg-pc-azul text-white px-4 py-2 rounded hover:bg-blue-600 shadow-sm">Modificar tarifa
                            actual</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- OTRAS OPCIONES --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold">Bicicletas</h2>
                <p class="mt-2">Gestiona las bicicletas del sistema.</p>
                <div class="mt-4 flex flex-col gap-2">
                    <a href="{{ route('bicicletas.index') }}"
                        class="bg-pc-azul text-white px-4 py-2 rounded hover:bg-blue-600">Ver todas las bicicletas</a>
                    <a href="{{ route('bicicletas.create') }}"
                        class="bg-pc-celeste text-white px-4 py-2 rounded hover:bg-green-600">Agregar bicicleta</a>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold">Estaciones</h2>
                <p class="mt-2">Gestiona las estaciones del sistema.</p>
                <div class="mt-4 flex flex-col gap-2">
                    <a href="{{ route('estaciones.index') }}"
                        class="bg-pc-azul text-white px-4 py-2 rounded hover:bg-blue-600">Ver todas las estaciones</a>
                    <a href="{{ route('estaciones.create') }}"
                        class=" bg-pc-celeste text-white px-4 py-2 rounded hover:bg-green-600">Agregar estación</a>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold">Informes</h2>
                <p class="mt-2">Gestiona los distintos informes del sistema.</p>
                <div class="mt-4 flex flex-col gap-2">
                    <a href="{{ route('informes') }}" class="bg-pc-azul text-white px-4 py-2 rounded hover:bg-blue-600">Ver
                        informes</a>
                </div>
            </div>
        </div>
    </div>
@endsection
