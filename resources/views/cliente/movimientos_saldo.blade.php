@extends('layouts.cliente')

@section('nombre_seccion', 'Actividad')

@section('contenido')
    <div class="flex flex-col w-full md:w-3/4 gap-4">
        {{-- FORMULARIO DE FECHAS --}}
        <!--<section class="flex gap-2 bg-gray-50 py-2 px-6 rounded-full text-sm items-center border-2">
            <p>icono</p>
            <form method="GET" action="{{ route('mov_saldo') }}" class="flex w-full">
                <div class="flex gap-2 w-full">
                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control text-sm border-none bg-gray-50 focus:outline-none focus:ring-0 w-full" required value="{{ $fechaInicio ?? '' }}">
                    <input type="date" id="fecha_fin" name="fecha_fin" class="form-control text-sm border-none bg-gray-50 focus:outline-none focus:ring-0 w-full" required value="{{ $fechaFin ?? '' }}">
                </div>
                <x-btn-rojo-blanco type="submit" class="capitalize">Buscar</x-btn-rojo-blanco>
            </form>
        </section>
    -->

        {{-- HISTORIAL --}}
        <div>
            <section class="bg-gray-50 rounded-xl shadow-md p-4">
                <div style="text-align: center;">
                    <h2>Movimientos de Saldo</h2>
                </div>
            @if($movimientos->count() > 0)
                @foreach($movimientos as $movimiento)
                    <div class="border rounded-lg p-4 mb-2 bg-white shadow-sm hover:bg-gray-100">
                        <div class="flex justify-between">
                            <div>
                                <h3 class="text-lg font-semibold">Motivo</h3>
                                <p class="text-gray-700">{{ $movimiento->motivo }}</p>
                            </div>
                            <div class="text-right">
                                <h3 class="text-lg font-semibold">Monto</h3>
                                <p class="text-gray-700 font-bold">{{ $movimiento->monto }}</p>
                            </div>
                        </div>
                        <div class="mt-2">
                            <h3 class="text-sm font-semibold">Fecha</h3>
                            <p class="text-gray-600">{{ $movimiento->fecha_hora }}</p>
                        </div>
                    </div>
                @endforeach
                <div class="mt-4">
                    {{ $movimientos->appends(['fecha_inicio' => request('fecha_inicio'), 'fecha_fin' => request('fecha_fin')])->links() }}
                </div>
            @else
                <p style="text-align: center">No se encontraron movimientos en el rango de fechas especificado.</p>
            @endif
        </section>
    </div>
@endsection

@section('scripts')
@endsection


