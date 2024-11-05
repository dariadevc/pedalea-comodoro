inicio

@extends('layouts.cliente')

@section('nombre_seccion', 'Inicio')

@section('contenido')
    <div class="flex flex-col gap-6">
        <div class="flex flex-col justify-center items-center gap-4">
            {{-- BIENVENIDA --}}
            <div class="flex flex-col md:flex-row items-center gap-1 md:gap-4">
                <!-- CAMBIAR LOGO POR LA VERSIÓN FINAL -->
                <img src="img/bicicleta.png" alt="" class="h-14 w-14">
                <p class="text-xl font-semibold text-pc-texto-h">¡Hola, <span class="font-extrabold text-2xl text-pc-rojo">{{ $datos['nombre']." ".$datos['apellido'] }}</span>!</p>
            </div>

            <div class="flex gap-4 w-full">
                {{-- SALDO DISPONIBLE --}}
                <div class="bg-gray-50 rounded-xl p-4 w-1/2 shadow-md">
                    <h2 class="text-sm text-left tracking-wider">Saldo
                        Disponible</h2>
                    <p class="text-2xl font-bold">${{ $datos['saldo'] }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 w-1/2 shadow-md">
                    <h2 class="text-sm text-left tracking-wider">Puntaje</h2>
                    <p class="text-2xl font-bold">{{ $datos['puntaje'] }} <span class="text-sm">pts</span></p>
                </div>
            </div>
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
        <div class="grid grid-cols-2 gap-6">
            {{-- CONSULTAR SALDO --}}
            <div class=" bg-gray-50 w-full h-36 p-4 shadow-md rounded-xl flex flex-col items-center gap-1">
                <svg width="50px" height="50px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0">
                    </g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path
                            d="M18 8V7.2C18 6.0799 18 5.51984 17.782 5.09202C17.5903 4.71569 17.2843 4.40973 16.908 4.21799C16.4802 4 15.9201 4 14.8 4H6.2C5.07989 4 4.51984 4 4.09202 4.21799C3.71569 4.40973 3.40973 4.71569 3.21799 5.09202C3 5.51984 3 6.0799 3 7.2V8M21 12H19C17.8954 12 17 12.8954 17 14C17 15.1046 17.8954 16 19 16H21M3 8V16.8C3 17.9201 3 18.4802 3.21799 18.908C3.40973 19.2843 3.71569 19.5903 4.09202 19.782C4.51984 20 5.07989 20 6.2 20H17.8C18.9201 20 19.4802 20 19.908 19.782C20.2843 19.5903 20.5903 19.2843 20.782 18.908C21 18.4802 21 17.9201 21 16.8V11.2C21 10.0799 21 9.51984 20.782 9.09202C20.5903 8.71569 20.2843 8.40973 19.908 8.21799C19.4802 8 18.9201 8 17.8 8H3Z"
                            stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </svg>
                <h3 class="text-center text-pc-texto-h semibol">Consultar Saldo</h3>
            </div>
            {{-- VER MAPA --}}
            <div class=" bg-gray-50 w-full h-36 p-4 shadow-md rounded-xl flex flex-col items-center gap-1">
                <svg width="50px" height="50px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path
                            d="M5.7 15C4.03377 15.6353 3 16.5205 3 17.4997C3 19.4329 7.02944 21 12 21C16.9706 21 21 19.4329 21 17.4997C21 16.5205 19.9662 15.6353 18.3 15M12 9H12.01M18 9C18 13.0637 13.5 15 12 18C10.5 15 6 13.0637 6 9C6 5.68629 8.68629 3 12 3C15.3137 3 18 5.68629 18 9ZM13 9C13 9.55228 12.5523 10 12 10C11.4477 10 11 9.55228 11 9C11 8.44772 11.4477 8 12 8C12.5523 8 13 8.44772 13 9Z"
                            stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </svg>
                <h3 class="text-center">Ver Estaciones</h3>
            </div>
            {{-- CONSULTAR MULTAS --}}
            <div class=" bg-gray-50 w-full h-36 p-4 shadow-md rounded-xl flex flex-col items-center gap-1">
                <svg width="50px" height="50px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path
                            d="M7 14H12.5M7 10H17M10 19H6.2C5.0799 19 4.51984 19 4.09202 18.782C3.71569 18.5903 3.40973 18.2843 3.21799 17.908C3 17.4802 3 16.9201 3 15.8V8.2C3 7.07989 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H17.8C18.9201 5 19.4802 5 19.908 5.21799C20.2843 5.40973 20.5903 5.71569 20.782 6.09202C21 6.51984 21 7.0799 21 8.2V8.5M14 20L16.025 19.595C16.2015 19.5597 16.2898 19.542 16.3721 19.5097C16.4452 19.4811 16.5147 19.4439 16.579 19.399C16.6516 19.3484 16.7152 19.2848 16.8426 19.1574L21 15C21.5523 14.4477 21.5523 13.5523 21 13C20.4477 12.4477 19.5523 12.4477 19 13L14.8426 17.1574C14.7152 17.2848 14.6516 17.3484 14.601 17.421C14.5561 17.4853 14.5189 17.5548 14.4903 17.6279C14.458 17.7102 14.4403 17.7985 14.405 17.975L14 20Z"
                            stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </svg>
                <h3 class="text-center">Consultar Multas</h3>
            </div>
            {{-- CONSULTAR SUSPENSIONES --}}
            <div class=" bg-gray-50 w-full h-36 p-4 shadow-md rounded-xl flex flex-col items-center gap-1">
                <svg width="50px" height="50px" fill="#000000" viewBox="0 0 96 96" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <title></title>
                        <path
                            d="M48,0A48,48,0,1,0,96,48,48.0512,48.0512,0,0,0,48,0Zm0,12a35.71,35.71,0,0,1,20.7993,6.7214L18.717,68.7935A35.8886,35.8886,0,0,1,48,12Zm0,72a35.71,35.71,0,0,1-20.7993-6.7214L77.283,27.2065A35.8886,35.8886,0,0,1,48,84Z">
                        </path>
                    </g>
                </svg>
                <h3 class="text-center">Consultar Suspensiones</h3>
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
