@extends('layouts.cliente')

@section('nombre_seccion', 'Actividad')

@section('contenido')
    <div class="flex flex-col w-full md:w-3/4 gap-4">
        {{-- HISTORIAL --}}
        <div class="text-2xl font-bold text-gray-700 mb-4 text-center">
            <h2>Actividades realizadas</h2>
        </div>
        {{-- FORMULARIO DE FECHAS --}}
        <section class="flex gap-2 bg-gray-50 py-2 px-6 rounded-full text-sm items-center border-2">
            <form method="GET" action="{{ route('actividad') }}" class="flex w-full gap-2">
                <div class="flex gap-2 w-full justify-center items-center">
                    <label for="fecha_inicio">Desde:</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio"
                        class="form-control text-sm border-none bg-gray-50 focus:outline-none focus:ring-0 w-40" required
                        value="{{ old('fecha_inicio', request('fecha_inicio')) }}">

                    <label for="fecha_fin">Hasta:</label>
                    <input type="date" id="fecha_fin" name="fecha_fin"
                        class="form-control text-sm border-none bg-gray-50 focus:outline-none focus:ring-0 w-40" required
                        value="{{ old('fecha_fin', request('fecha_fin')) }}">
                </div>
                <x-btn-rojo-blanco type="submit" class="capitalize">Buscar</x-btn-rojo-blanco>
            </form>
        </section>

        {{-- HISTORIAL --}}
        <section class="grid auto-rows-max gap-2 bg-gray-50 rounded-xl shadow-md">
            {{-- LISTA DE ACTIVIDADES --}}
            <ul class="">
                @if ($reservas->count() > 0)
                    @foreach ($reservas as $reserva)
                        <li class="flex flex-col box-border p-4 hover:bg-gray-100 w-full">
                            <div class="flex flex-col mb-2">
                                <h2 class="text-sm font-semibold">Reserva</h2>
                                @if ($reserva->estado == 'Cancelada')
                                    <p class="text-pc-rojo font-semibold">{{ $reserva->estado }}</p>
                                @elseif ($reserva->estado == 'Activa')
                                    <p class="text-pc-azul font-semibold">{{ $reserva->estado }}</p>
                                @else
                                    <p class="text-gray-400 font-semibold">{{ $reserva->estado }}</p>
                                @endif
                                <p class="text-sm font-semibold">Fecha de retiro</p>
                                <p class="text-sm">
                                    {{ ucfirst(\Carbon\Carbon::parse($reserva->fecha_hora_retiro)->locale('es')->translatedFormat('l, d \d\e F Y \a \l\a\s h:i')) }}
                                </p>
                            </div>
                            <details class="w-full">
                                <summary class="cursor-pointer btn btn-info">
                                    Ver Detalles
                                </summary>
                                <div class="mt-2">
                                    <p>Bicicleta: {{ $reserva->bicicleta_patente }}</p>
                                    <p>Estación de Retiro: {{ $reserva->estacion_retiro_nombre }}</p>
                                    <p>Estación de Devolución: {{ $reserva->estacion_devolucion_nombre }}</p>
                                    <p>Fecha de Retiro: {{ $reserva->fecha_hora_retiro }}</p>
                                    <p>Fecha de Devolución: {{ $reserva->fecha_hora_devolucion }}</p>
                                    <p>Puntaje Obtenido: {{ $reserva->puntaje }}</p>
                                </div>
                            </details>
                        </li>
                    @endforeach
                @else
                    <p style="text-center">No se encontraron reservas en el rango de fechas especificado.</p>
                @endif
            </ul>
            <div>
                {{ $reservas->appends(['fecha_inicio' => request('fecha_inicio'), 'fecha_fin' => request('fecha_fin')])->links() }}
            </div>
        </section>
    </div>
@endsection

@section('scripts')
@endsection
