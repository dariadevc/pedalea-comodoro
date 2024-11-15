@extends('layouts.cliente')

@section('nombre_seccion', 'Historial de Suspensiones')

@section('contenido')
    <div class="flex flex-col w-full md:w-3/4 gap-4 items-center">
        {{-- HISTORIAL --}}
        <div class="text-2xl font-bold text-gray-700 mb-4 text-center hidden lg:block">
            <h2>Historial de Suspensiones</h2>
        </div>

        {{-- FORMULARIO DE FECHAS --}}
        <section class="gap-2 bg-gray-50 py-2 px-6 rounded-full text-sm border-2 inline-flex w-fit">
            <form method="GET" action="{{ route('his_suspensiones') }}" class="flex gap-2 justify-center w-fit">
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
        <section class="bg-gray-50 rounded-xl shadow-md p-4">
            @if ($suspensiones->count() > 0)
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left">Estado</th>
                            <th class="py-2 px-4 border-b text-left">Fecha Desde</th>
                            <th class="py-2 px-4 border-b text-left">Fecha Hasta</th>
                            <th class="py-2 px-4 border-b text-left">Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suspensiones as $suspension)
                            <tr class="hover:bg-gray-100">
                                <td class="py-2 px-4 border-b font-semibold">{{ $suspension->nombre_estado }}</td>
                                <td class="text-base py-2 px-4 border-b">{{ $suspension->fecha_desde->format('d/m/Y') }}
                                </td>
                                <td class="text-base py-2 px-4 border-b">{{ $suspension->fecha_hasta->format('d/m/Y') }}
                                </td>
                                <td class="text-base py-2 px-4 border-b">{{ $suspension->descripcion }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $suspensiones->appends(['fecha_inicio' => request('fecha_inicio'), 'fecha_fin' => request('fecha_fin')])->links() }}
                </div>
            @else
                <p style="text-align: center">No se encontraron suspensiones en el rango de fechas especificado.</p>
            @endif
        </section>
    </div>
@endsection

@section('scripts')
@endsection
