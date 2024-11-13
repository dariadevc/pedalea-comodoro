@extends('layouts.cliente')

@section('nombre_seccion', 'Actividad')

@section('contenido')
    <div class="flex flex-col w-full md:w-3/4 gap-4">
        {{-- FORMULARIO DE FECHAS --}}
        <section class="flex gap-2 bg-gray-50 py-2 px-6 rounded-full text-sm items-center border-2">
            <form method="GET" action="{{ route('his_suspensiones') }}" class="flex w-full">
                <div class="flex gap-2 w-full">
                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control text-sm border-none bg-gray-50 focus:outline-none focus:ring-0 w-full" required value="{{ $fechaInicio ?? '' }}">
                    <input type="date" id="fecha_fin" name="fecha_fin" class="form-control text-sm border-none bg-gray-50 focus:outline-none focus:ring-0 w-full" required value="{{ $fechaFin ?? '' }}">
                </div>
                <x-btn-rojo-blanco type="submit" class="capitalize">Buscar</x-btn-rojo-blanco>
            </form>
        </section>

        {{-- HISTORIAL --}}
        <section class="bg-gray-50 rounded-xl shadow-md p-4">
            @if($suspensiones->count() > 0)
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left">Estado</th>
                            <th class="py-2 px-4 border-b text-left">Fecha Desde</th>
                            <th class="py-2 px-4 border-b text-left">Fecha Hasta</th>
                            <th class="py-2 px-4 border-b text-left">Fecha Hora</th>
                            <th class="py-2 px-4 border-b text-left">Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($suspensiones as $suspension)
                            <tr class="hover:bg-gray-100">
                                <td class="py-2 px-4 border-b">{{ $suspension->estado }}</td>
                                <td class="py-2 px-4 border-b">{{ $suspension->fecha_desde }}</td>
                                <td class="py-2 px-4 border-b">{{ $suspension->fecha_hasta }}</td>
                                <td class="py-2 px-4 border-b">{{ $suspension->fecha_hora }}</td>
                                <td class="py-2 px-4 border-b">{{ $suspension->descripcion }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $suspensiones->appends(['fecha_inicio' => request('fecha_inicio'), 'fecha_fin' => request('fecha_fin')])->links() }}
                </div>
            @else
                <p style="text-align: center">No se encontraron reservas en el rango de fechas especificado.</p>
            @endif
        </section>
    </div>
@endsection

@section('scripts')
@endsection
