@extends('layouts.cliente')

@section('nombre_seccion', 'Historial de Multas')

@section('contenido')
    <div class="flex flex-col w-full md:w-3/4 gap-4 items-center">
        {{-- HISTORIAL --}}
        <div class="text-2xl font-bold text-pc-texto-h mb-4 text-center hidden lg:block">
            <h2>Historial de Multas</h2>
        </div>
        @if (session('success'))
            <div class="alert alert-success bg-pc-azul text-white rounded-md p-4 mb-2 font-semibold text-center text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- FORMULARIO DE FECHAS --}}
        <section class="gap-2 bg-gray-50 py-2 px-6 rounded-full text-sm border-2 inline-flex w-fit">
            <form method="GET" action="{{ route('his_multas') }}" class="flex gap-2 justify-center w-fit">
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
        <section class="bg-gray-50 rounded-xl shadow-md p-4 w-full">
            @if ($multas->count() > 0)
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left">Estado</th>
                            <th class="py-2 px-4 border-b text-left">Monto</th>
                            <th class="py-2 px-4 border-b text-left">Fecha y Hora</th>
                            <th class="py-2 px-4 border-b text-left">Descripción</th>
                            <th class="py-2 px-4 border-b text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($multas as $multa)
                            <tr class="hover:bg-gray-100">
                                <td class="py-2 px-4 border-b font-semibold">{{ $multa->nombre_estado }}</td>
                                <td class="py-2 px-4 border-b">${{ $multa->monto }}</td>
                                <td class="py-2 px-4 border-b">{{ $multa->fecha_hora->format('d/m/Y H:i') }}</td>
                                <td class="py-2 px-4 border-b">{{ $multa->descripcion }}</td>
                                @if ($multa->nombre_estado == 'Pendiente')
                                    <td class="py-2 px-4 border-b">
                                        <form action="{{ route('multas.pagar', $multa->id_multa) }}" method="POST">
                                            @csrf
                                            <x-btn-rojo-blanco type="submit">Pagar</x-btn-rojo-blanco>
                                        </form>
                                        {{-- <input type="hidden" name="id_multa" value="{{ $multa->id_multa }}"> --}}
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $multas->appends(['fecha_inicio' => request('fecha_inicio'), 'fecha_fin' => request('fecha_fin')])->links() }}
                </div>
            @else
                <p style="text-align: center">No se encontraron multas en el rango de fechas especificado.</p>
            @endif
        </section>
    </div>
@endsection

@section('scripts')
@endsection
