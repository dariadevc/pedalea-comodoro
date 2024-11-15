@extends('layouts.cliente')

@section('nombre_seccion', 'Actividad')

@section('contenido')
    <div class="flex flex-col w-full md:w-3/4 gap-4 items-center ">
        {{-- HISTORIAL --}}
        <div class="text-2xl font-bold text-gray-700 mb-4 text-center hidden lg:block">
            <h2>Actividades realizadas</h2>
        </div>
        {{-- FORMULARIO DE FECHAS --}}
        <section class="gap-2 bg-gray-50 py-2 px-6 rounded-full text-sm border-2 inline-flex w-fit">
            <form method="GET" action="{{ route('actividad') }}" class="flex gap-2 justify-center w-fit">
                <div class="flex gap-2 justify-center items-center">
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
        <section class="grid auto-rows-max gap-2 bg-gray-50 rounded-xl shadow-md w-full">
            {{-- LISTA DE ACTIVIDADES --}}

            @if ($reservas->count() > 0)
                <ul x-data="{ openDetails: null }">
                    @foreach ($reservas as $index => $reserva)
                        <li
                            class="flex flex-col box-border p-4 w-full border-b-2 hover:bg-gradient-to-t from-gray-100 to-transparent">
                            <div class="flex flex-col mb-2">
                                <h2 class="font-bold -mb-1">Reserva</h2>
                                @if ($reserva->estado == 'Cancelada')
                                    <p class="text-pc-rojo text-lg font-semibold">{{ $reserva->estado }}</p>
                                @elseif ($reserva->estado == 'Activa')
                                    <p class="text-pc-azul text-lg font-semibold">{{ $reserva->estado }}</p>
                                @else
                                    <p class="text-gray-400 text-lg font-semibold">{{ $reserva->estado }}</p>
                                @endif
                                <p class="font-semibold mt-1">Fecha de creación</p>
                                <p class="text-sm">

                                    {{ ucfirst(\Carbon\Carbon::parse($reserva->created_at)->locale('es')->translatedFormat('l, d \d\e F Y \a \l\a\s H:i')) }}
                                </p>
                            </div>
                            <details x-bind:open="openDetails === {{ $index }}" class="w-full mt-2 border-t-2">
                                <summary
                                    @click.prevent="openDetails = openDetails === {{ $index }} ? null : {{ $index }}"
                                    class="cursor-pointer font-semibold py-1 pl-2 hover:pl-3">
                                    Más Detalles
                                </summary>
                                <div class="mt-2 flex flex-col gap-1 pl-4">
                                    <div class="flex items-center">
                                        <span class="font-semibold text-sm text-gray-600 w-48 mr-3">Fecha de Retiro</span>
                                        <span
                                            class="text-gray-700 text-sm">{{ ucfirst(\Carbon\Carbon::parse($reserva->fecha_hora_retiro)->locale('es')->translatedFormat('l, d \d\e F Y \a \l\a\s H:i')) }}</span>
                                    </div>
                                    @if ($reserva->estado != 'Cancelada')
                                        <div class="flex items-center">
                                            <span class="font-semibold text-sm text-gray-600 w-48 mr-3">Fecha de
                                                Devolución</span>
                                            <span
                                                class="text-gray-700 text-sm">{{ ucfirst(\Carbon\Carbon::parse($reserva->fecha_hora_devolucion)->locale('es')->translatedFormat('l, d \d\e F Y \a \l\a\s H:i')) }}</span>
                                        </div>
                                    @endif
                                    <div class="flex items-center">
                                        <span class="font-semibold text-sm text-gray-600 w-48 mr-3">Estación de
                                            Retiro</span>
                                        <span class="text-gray-700 text-sm">{{ $reserva->estacion_retiro_nombre }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="font-semibold text-sm text-gray-600 w-48 mr-3">Estación de
                                            Devolución</span>
                                        <span
                                            class="text-gray-700 text-sm">{{ $reserva->estacion_devolucion_nombre }}</span>
                                    </div>

                                    @if ($reserva->nombre_usuario_devuelve && $reserva->apellido_usuario_devuelve)
                                        <div class="flex items-center">
                                            <span class="font-semibold text-sm text-gray-600 w-48 mr-3">Cliente
                                                Devuelve</span>
                                            <span
                                                class="text-gray-700 text-sm">{{ $reserva->apellido_usuario_devuelve . $reserva->nombre_usuario_devuelve }}</span>
                                        </div>
                                    @endif
                                    @if ($reserva->puntaje)
                                        <div class="flex items-center">
                                            <span class="font-semibold text-sm text-gray-600 w-48 mr-3">Puntaje
                                                Obtenido</span>
                                            @if ($reserva->puntaje <= 0)
                                                <span class="text-pc-rojo font-bold text-sm">{{ $reserva->puntaje }}</span>
                                            @else
                                                <span class="text-pc-azul font-bold text-sm">{{ $reserva->puntaje }}</span>
                                            @endif

                                        </div>
                                    @endif
                                </div>
                            </details>
                        </li>
                    @endforeach
                </ul>
                <div>
                    {{ $reservas->appends(['fecha_inicio' => request('fecha_inicio'), 'fecha_fin' => request('fecha_fin')])->links() }}
                </div>
            @else
                <p class="text-center p-4">No se encontraron reservas en el rango de fechas especificado.</p>
            @endif

        </section>
    </div>
@endsection

@section('scripts')
@endsection
