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
                                <p class="text-sm font-semibold">Fecha de creación</p>
                                <p class="text-sm">
                                    
                                    {{ ucfirst(\Carbon\Carbon::parse($reserva->created_at)->locale('es')->translatedFormat('l, d \d\e F Y \a \l\a\s H:i')) }}
                                </p>
                            </div>
                            <details class="w-full">
                                <summary class="cursor-pointer btn btn-info">
                                    Ver Detalles
                                </summary>
                                <div class="mt-2">
                                    <div class="flex items-center">
                                        <span class="font-medium text-gray-600 w-48 mr-3">Fecha de Retiro</span>
                                        <span
                                            class="text-gray-700">{{ ucfirst(\Carbon\Carbon::parse($reserva->fecha_hora_retiro)->locale('es')->translatedFormat('l, d \d\e F Y \a \l\a\s H:i')) }}</span>
                                    </div>
                                    @if ($reserva->estado != 'Cancelada')
                                        <div class="flex items-center">
                                            <span class="font-medium text-gray-600 w-48 mr-3">Fecha de Devolución</span>
                                            <span
                                                class="text-gray-700">{{ ucfirst(\Carbon\Carbon::parse($reserva->fecha_hora_devolucion)->locale('es')->translatedFormat('l, d \d\e F Y \a \l\a\s H:i')) }}</span>
                                        </div>
                                    @endif
                                    <div class="flex items-center">
                                        <span class="font-medium text-gray-600 w-48 mr-3">Estación de Retiro</span>
                                        <span class="text-gray-700">{{ $reserva->estacion_retiro_nombre }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="font-medium text-gray-600 w-48 mr-3">Estación de Devolución</span>
                                        <span class="text-gray-700">{{ $reserva->estacion_devolucion_nombre }}</span>
                                    </div>
                                    @if ($reserva->puntaje)
                                        <div class="flex items-center">
                                            <span class="font-medium text-gray-600 w-48 mr-3">Puntaje Obtenido</span>
                                            <span class="text-gray-700">{{ $reserva->puntaje }}</span>
                                        </div>
                                    @endif
                                    @if ($reserva->nombre_usuario_devuelve && $reserva->apellido_usuario_devuelve)
                                        <div class="flex items-center">
                                            <span class="font-medium text-gray-600 w-48 mr-3">Cliente Devuelve</span>
                                            <span
                                                class="text-gray-700">{{ $reserva->apellido_usuario_devuelve . $reserva->nombre_usuario_devuelve }}</span>
                                        </div>
                                    @endif
                                </div>
                            </details>
                        </li>
                    @endforeach
                    <div>
                        {{ $reservas->appends(['fecha_inicio' => request('fecha_inicio'), 'fecha_fin' => request('fecha_fin')])->links() }}
                    </div>
                @else
                    <p style="text-center">No se encontraron reservas en el rango de fechas especificado.</p>
                @endif
            </ul>
        </section>
    </div>
@endsection

@section('scripts')
@endsection
