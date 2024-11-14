@extends('layouts.administrativo')

@section('nombre_seccion', 'Informes')

@section('contenido')
    {{-- <div x-data="{ activeButton: null }" class="w-full flex flex-col gap-4">
        <div class="flex justify-around p-1 py-2 rounded-full">
            <button @click="activeButton = 'multas'"
                :class="activeButton === 'multas' ? 'bg-pc-rojo text-white font-bold' :
                    'bg-white hover:shadow-md border-2 border-pc-rojo hover:font-semibold'"
                class="py-1 px-3 rounded-full">Multas
                Realizadas</button>
            <button @click="activeButton = 'estaciones'"
                :class="activeButton === 'estaciones' ? 'bg-pc-rojo text-white font-bold' :
                    'bg-white hover:shadow-md border-2 border-pc-rojo hover:font-semibold'"
                class="py-1 px-3 rounded-full">
                Estaciones Utilizadas
            </button>
            <button @click="activeButton = 'rutas'"
                :class="activeButton === 'rutas' ? 'bg-pc-rojo text-white font-bold' :
                    'bg-white hover:shadow-md border-2 border-pc-rojo hover:font-semibold'"
                class="py-1 px-3 rounded-full">
                Rutas Utilizadas
            </button>
            <button @click="activeButton = 'alquiler'"
                :class="activeButton === 'alquiler' ? 'bg-pc-rojo text-white font-bold' :
                    'bg-white hover:shadow-md border-2 border-pc-rojo hover:font-semibold'"
                class="py-1 px-3 rounded-full">
                Alquiler Tiempo/Hora
            </button>
        </div>
        <div id="contenedor-informe" class="place-self-center bg-gray-50 w-full p-4 rounded-lg shadow-md">
            <template x-if="activeButton === null">
                <p class="text-center">Seleccione el informe al que desea acceder.</p>
            </template>
            <template x-if="activeButton === 'multas'">
                <p class="text-center">Contenido del informe de Multas Realizadas.</p>
            </template>
            <template x-if="activeButton === 'estaciones'">
                <p class="text-center">Contenido del informe de Estaciones Utilizadas.</p>
            </template>
            <template x-if="activeButton === 'rutas'">
                <p class="text-center">Contenido del informe de Rutas Utilizadas.</p>
            </template>
            <template x-if="activeButton === 'alquiler'">
                @include('administrativo.informes.alquilerInforme')
            </template>
        </div>
    </div> --}}

    {{-- TODO: Conectar para que se muestre bien el informe en el contenedor!! Capaz es mejor usar jquery que alpinejs --}}
    <div x-data="{ informeActual: '' }" class="w-full flex flex-col gap-4">
        <div class="flex justify-around p-1 py-2 rounded-full">
            <button @click="informeActual = 'multas'"
                :class="informeActual === 'multas' ? 'bg-pc-rojo text-white font-bold' : 'bg-white text-current'"
                class="informes-btn py-1 px-3 rounded-full hover:shadow-md border-2 border-pc-rojo"
                data-url="{{ route('informes.multas') }}">
                Multas Realizadas
            </button>
            <button @click="informeActual = 'estaciones'"
                :class="informeActual === 'estaciones' ? 'bg-pc-rojo text-white font-bold' : 'bg-white text-current'"
                class="informes-btn py-1 px-3 rounded-full hover:shadow-md border-2 border-pc-rojo"
                data-url="{{ route('informes.estaciones') }}">
                Estaciones Utilizadas
            </button>
            <button @click="informeActual = 'rutas'"
                :class="informeActual === 'rutas' ? 'bg-pc-rojo text-white font-bold' : 'bg-white text-current'"
                class="informes-btn py-1 px-3 rounded-full hover:shadow-md border-2 border-pc-rojo"
                data-url="{{ route('informes.rutas') }}">
                Rutas Utilizadas
            </button>
            <button @click="informeActual = 'alquiler'"
                :class="informeActual === 'alquiler' ? 'bg-pc-rojo text-white font-bold' : 'bg-white text-current'"
                class="informes-btn py-1 px-3 rounded-full hover:shadow-md border-2 border-pc-rojo"
                data-url="{{ route('informes.tiempoHorario') }}">
                Alquiler Tiempo/Hora
            </button>
            <!-- Agrega más botones para los otros informes -->
        </div>

        <div id="contenedor-informe" class="place-self-center bg-gray-50 w-full p-4 rounded-lg shadow-md">
            <p class="text-center" x-show="!informeActual">Seleccione el informe al que desea acceder.</p>
        </div>
    </div>

@endsection
