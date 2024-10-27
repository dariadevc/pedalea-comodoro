@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-6">
            <h3 class="text-3xl font-bold mb-4 text-center text-black">Informes de Estaciones</h3>
            <form method="GET" action="{{ route('informes.estaciones') }}" class="bg-sky-100 p-6 rounded shadow-md">
                <label for="fecha_inicio">Desde:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" required value="{{ $fechaInicio ?? '' }}">
                <label for="fecha_fin">Hasta:</label>
                <input type="date" id="fecha_fin" name="fecha_fin" required value="{{ $fechaFin ?? '' }}">
                <button type="submit" class="bg-lime-500 hover:bg-lime-700 text-white font-bold py-2 px-4 rounded">Generar Informe</button>        
            </form>
        </div>
             <br>
        <div class="container mx-auto mt-6">
             @if(isset($estaciones) && count($estaciones) > 0)
             <h1 class="text-2xl font-bold mb-4 text-black underline">Listado de Estaciones</h1>
                <table class="min-w-full border-collapse block md:table">
                    <thead class="block md:table-header-group">
                        <tr  class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto  md:relative ">
                            <th class="bg-sky-100 p-2 text-black font-bold md:border md:border-black text-left block md:table-cell">Nombre</th>
                            <th class="bg-sky-100 p-2 text-black font-bold md:border md:border-black text-left block md:table-cell">Nro.Estacion</th>
                            <th class="bg-sky-100 p-2 text-black font-bold md:border md:border-black text-left block md:table-cell">Estaciones mas utilizadas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($estaciones as $estacion)
                            <tr class="bg-sky-50 border border-grey-500 md:border-none block md:table-row">
                                <td class="p-2 md:border md:border-black text-left block md:table-cell">{{ $estacion->nombre }}</td>
                                <td class="p-2 md:border md:border-black text-left block md:table-cell">{{ $estacion->id_estacion_retiro }}</td>
                                <td class="p-2 md:border md:border-black text-left block md:table-cell">{{ $estacion->total_reservas }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    <p class="mt-6 text-center text-gray-500">No hay datos disponibles para el rango de fechas seleccionado.</p>
            @endif
        </div>
@endsection




