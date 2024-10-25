@extends('layouts.cliente')

@section('titulo', 'Pedalea Comodoro | Alquilar')

@section('nombre_seccion', 'Alquilar')

@section('contenido')
    {{-- MOSTRAR DATOS DE RESERVA --}}
    <div class="flex flex-col gap-4">
        <div class="">
            <p class="text-pc-texto-p text-sm border-l-4 border-l-pc-azul pl-2">Datos de tu reserva</p>
        </div>
        <div class="bg-gradient-to-br from-pc-celeste to-pc-azul p-4 shadow-md rounded-xl flex flex-col gap-6 w-full">
            <div class="rounded-xl bg-gray-50 p-4 shadow-md flex flex-col gap-3">
                <div class="flex flex-col gap-1">
                    <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-azul self-start">Estación de
                        Retiro</h3>
                    <p class="pl-4 text-lg">Av. Tehuelches</p>
                </div>
                <div class="flex flex-col gap-1">
                    <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-azul self-start">Estación de
                        Devolución</h3>
                    <p class="pl-4 text-lg">Av. Alsina</p>
                </div>
                <div class="flex flex-col gap-1">
                    <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-azul self-start">Horas de
                        Alquiler</h3>
                    <p class="pl-4 text-lg">3hs</p>
                </div>
                <div class="flex flex-col gap-1">
                    <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-azul self-start">Horario de
                        Devolución</h3>
                    <p class="pl-4 text-lg">21:00hs</p>
                </div>
                <div class="flex flex-col gap-1">
                    <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-azul self-start">Bicicleta
                        Asignada</h3>
                    <p class="pl-4 text-lg">#016</p>
                </div>
                <div class="flex flex-col gap-1">
                    <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-azul self-start">Monto
                        Restante a Pagar</h3>
                    <p class="pl-4 text-lg">$2250,00</p>
                </div>
            </div>
        </div>
    </div>
    {{-- INDICAR DISPONIBILIDAD DE BICICLETA EN LA ESTACIÓN --}}
    <div class="flex flex-col gap-4">
        <div class="">
            <p class="text-pc-texto-p text-sm border-l-4 border-l-pc-azul pl-2">¿La bicicleta se encuentra en la
                estación?</p>
        </div>
        <div class="flex gap-6 self-center">
            {{-- <form action="{{ route('alquilar.store') }}" method="POST">
                @csrf
                <button class="py-2 w-20 rounded-full font-semibold bg-slate-50 shadow-md border-4 border-pc-azul">Si</button>
            </form>
            <form action="{{ route('alquilar.store') }}" method="POST">
                @csrf
                <button class="py-2 w-20 rounded-full font-semibold bg-slate-50 shadow-md border-4 border-pc-azul">No</button>
            </form> --}}
            <form action="{{ route('alquilar.store') }}" method="POST">
                @csrf
                <button type="submit" name="bicicletaDisponible" value="1" class="py-2 w-20 rounded-full font-semibold bg-slate-50 shadow-md border-4 border-pc-azul">Si</button>
                <button type="submit" name="bicicletaDisponible" value="0" class="py-2 w-20 rounded-full font-semibold bg-slate-50 shadow-md border-4 border-pc-azul">No</button>
            </form>
        </div>
    </div>
    {{-- PAGAR ALQUILER --}}
    {{-- TODO: Mostrar lo que corresponda según la selección que haga en el div anterior --}}
    <div class="flex flex-col gap-4 hidden">
        <div class="">
            <p class="text-pc-texto-p text-sm border-l-4 border-l-pc-azul pl-2">
                Ya podes pagar el alquiler para retirar tu bicicleta!
            </p>
        </div>
        {{-- TODO: Al apretar el botón debería saltar un cartel que tenga un mensaje informando que la reserva se realizó con éxito y un botón que te manda al inicio --}}
        <div class="flex gap-6 self-center">
            <button class="py-2 px-4 rounded-full font-semibold bg-slate-50 shadow-md border-4 border-pc-azul">
                Pagar Alquiler
            </button>
        </div>
    </div>
@endsection
