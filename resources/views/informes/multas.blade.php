@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-6">
        <h3 class="text-3xl font-bold mb-4 text-center text-black">Informes de Multas</h3>
        <form method="GET" action="{{ route('informes.multas') }}" class="bg-sky-100 p-6 rounded shadow-md">
            <label for="fecha_inicio">Desde:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" required>
            
            <label for="fecha_fin">Hasta:</label>
            <input type="date" id="fecha_fin" name="fecha_fin" required>
            <button type="submit" class="bg-lime-500 hover:bg-lime-700 text-white font-bold py-2 px-4 rounded">Generar Informe</button>
    </div>
        </form>
    <br>
    <div  class="container mx-auto mt-6">
        @if(isset($multas) && count($multas) > 0)
        <h1 class="text-2xl font-bold mb-4 text-black underline">Listado de Multas</h1>
        <table class="min-w-full border-collapse block md:table">
            <thead class="block md:table-header-group">
                <tr  class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto  md:relative ">
                    <th class="bg-sky-100 p-2 text-black font-bold md:border md:border-black text-left block md:table-cell">Cliente</th>
                    <th class="bg-sky-100 p-2 text-black font-bold md:border md:border-black text-left block md:table-cell">Monto</th>
                    <th class="bg-sky-100 p-2 text-black font-bold md:border md:border-black text-left block md:table-cell">Fecha y Hora</th>
                    <th class="bg-sky-100 p-2 text-black font-bold md:border md:border-black text-left block md:table-cell">Descripción</th>
                </tr>
            </thead>
            <tbody class="block md:table-row-group">
                @foreach($multas as $multa)
                <tr class="bg-sky-50 border border-grey-500 md:border-none block md:table-row">
                    <td class="p-2 md:border md:border-black text-left block md:table-cell">{{ $multa->nombre_usuario}}</td>
                    <td class="p-2 md:border md:border-black text-left block md:table-cell">{{ $multa->monto }}</td>
                    <td class="p-2 md:border md:border-black text-left block md:table-cell">{{ $multa->fecha_hora }}</td>
                    <td class="p-2 md:border md:border-black text-left block md:table-cell">{{ $multa->descripcion }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>No se encontraron multas en este rango de fechas.</p>
        @endif
    </div>
@endsection




