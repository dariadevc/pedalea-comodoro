@extends('layouts.cliente')

@section('nombre_seccion', 'Movimientos de Saldo')

@section('contenido')
    <div class="flex flex-col w-full md:w-3/4 gap-4">

        {{-- HISTORIAL --}}
        <div class="text-2xl font-bold text-pc-texto-h mb-4 text-center hidden lg:block">
            <h2>Movimientos de Saldo</h2>
        </div>
        <div>
            <section class="bg-gray-50 rounded-xl shadow-md p-4">
                @if ($movimientos->count() > 0)
                    @foreach ($movimientos as $movimiento)
                        <div class="border rounded-lg p-4 mb-2 bg-white shadow-sm hover:shadow-md">
                            <div class="flex justify-between">
                                <div>
                                    <h3 class="text-sm font-semibold">Motivo</h3>
                                    <p class="text-lg font-bold text-pc-texto-h">{{ $movimiento->motivo }}</p>
                                </div>
                                <div class="text-right">
                                    <h3 class="text-sm font-semibold">Monto</h3>
                                    <p class="text-lg font-bold text-pc-texto-h">${{ $movimiento->monto }}</p>
                                </div>
                            </div>
                            <div class="mt-2">
                                <h3 class="text-sm font-semibold">Fecha</h3>
                                <p class="text-sm text-pc-texto-p">
                                    {{ ucfirst($movimiento->fecha_hora->locale('es')->translatedFormat('l, d \d\e F Y') . ' a las ' . $movimiento->fecha_hora->format('h:i')) }}
                                </p>
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
