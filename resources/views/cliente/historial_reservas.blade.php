@extends('layouts.cliente')

@section('nombre_seccion', 'Actividad')

@section('contenido')
    <div class="flex flex-col w-full md:w-3/4 gap-4">
        {{-- FORMULARIO DE FECHAS --}}
        <section class="flex gap-2 bg-gray-50 py-2 px-6 rounded-full text-sm items-center border-2">
            <form method="GET" action="{{ route('actividad') }}" class="flex w-full">
                <div class="flex gap-2 w-full">
                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control text-sm border-none bg-gray-50 focus:outline-none focus:ring-0 w-full" required value="{{ $fechaInicio ?? '' }}">
                    <input type="date" id="fecha_fin" name="fecha_fin" class="form-control text-sm border-none bg-gray-50 focus:outline-none focus:ring-0 w-full" required value="{{ $fechaFin ?? '' }}">
                </div>
                <x-btn-rojo-blanco type="submit" class="capitalize">Buscar</x-btn-rojo-blanco>
            </form>
        </section>

        {{-- FILTRAR --}}
       <!-- <section class="flex bg-gray-50 p-4 justify-between items-center text-sm rounded-md shadow-sm">
            <div class="flex gap-2">
                 <div>
                    <button class="flex gap-4 items-center px-2 py-1" type="button">
                        <span class="">Período</span>
                        <x-icon-flecha-abajo-oscura width="15px" height="15px" />
                    </button>
                </div> 
                <div>
                    <button class="flex gap-4 items-center px-2 py-1" type="button">
                        <span class="">Estados</span>
                        <x-icon-flecha-abajo-oscura width="15px" height="15px" />
                    </button>
                </div>
            </div>
            <div>
                <button type="button" class="text-gray-400">Borrar filtros</button>
            </div>
        </section> --> 

        {{-- HISTORIAL --}}
        <section class="grid auto-rows-max gap-2 bg-gray-50 rounded-xl shadow-md">
            {{-- LISTA DE ACTIVIDADES --}}
            <ul class="">
                @if($reservas->count() > 0)
                    @foreach($reservas as $reserva)
                        <li class="flex flex-col box-border p-4 hover:bg-gray-100 w-full">
                            <div class="flex flex-col mb-2">
                                <h2>Reserva</h2>
                                <p>Estado: {{ $reserva->estado }}</p>
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
                    <p style="text-align: center">No se encontraron reservas en el rango de fechas especificado.</p>
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




