@extends('layouts.cliente')

@section('nombre_seccion', 'Historial de Multas')

@section('contenido')
    <div class="flex flex-col w-full md:w-3/4 gap-4 items-center">
        {{-- HISTORIAL --}}
        <div class="text-2xl font-bold text-pc-texto-h mb-4 text-center hidden lg:block">
            <h2>Historial de Multas</h2>
        </div>
        <div id="alertaSuccess" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative hidden"
            role="alert">
            <span class="block sm:inline"></span>
        </div>

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
                                <td data-id="{{ $multa->id_multa }}" class="nombreEstado py-2 px-4 border-b font-semibold">
                                    {{ $multa->nombre_estado }}</td>
                                <td class="py-2 px-4 border-b">${{ $multa->monto }}</td>
                                <td class="py-2 px-4 border-b">{{ $multa->fecha_hora->format('d/m/Y H:i') }}</td>
                                <td class="py-2 px-4 border-b">{{ $multa->descripcion }}</td>
                                @if ($multa->nombre_estado == 'Pendiente')
                                    <td data-id="{{ $multa->id_multa }}" class="columnaPagar py-2 px-4 border-b">
                                        <form action="{{ route('multas.pagar', $multa->id_multa) }}" method="POST"
                                            class="ajax-pago">
                                            @csrf
                                            <x-btn-rojo-blanco type="submit">Pagar</x-btn-rojo-blanco>
                                        </form>
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

    <div id="modalConfirmacion"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 invisible">
        <div class="bg-white p-6 rounded-lg shadow-lg w-11/12 sm:w-1/3">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Saldo insuficiente para pagar el alquiler. ¿Quiere cargar
                saldo en su cuenta?</h2>
            <div class="flex gap-4 justify-center">
                <button onclick="mostrarCargarSaldo()"
                    class="shadow-md py-3 px-6 rounded-full transition duration-500 font-semibold uppercase bg-slate-50 outline outline-4 -outline-offset-4 outline-pc-azul text-pc-azul hover:bg-pc-azul hover:text-slate-50">
                    Si
                </button>
                <button type="button" onclick="toggleModal('modalConfirmacion')"
                    class="shadow-md py-3 px-6 rounded-full transition duration-500 font-semibold uppercase bg-slate-50 outline outline-4 -outline-offset-4 outline-pc-azul text-pc-azul hover:bg-pc-azul hover:text-slate-50">
                    No
                </button>
            </div>
        </div>
    </div>

    <div id="overlay" class="fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-30 invisible">
        <div id="tarjeta_cargar_saldo"
            class="relative flex flex-col bg-white rounded-3xl shadow-xl w-[500px] max-w-[90%]">
            
            <!-- Botón de cerrar -->
            <button id="cerrar_tarjeta" class="absolute right-6 top-6 text-gray-400 hover:text-gray-600 transition-colors" onclick="ocultarBusqueda()">
                <svg xmlns="http://www.w3.org/2000/svg" height="20px" width="20px" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
    
            <!-- Contenido -->
            <div class="p-8">
                @include('cliente.partials.pasarela-de-pago')
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/cargar-saldo.js')
    <script>
        function toggleModal(id_contenedor) {
            $(`#${id_contenedor}`).toggleClass('invisible');
        }


        $(document).ready(function() {
            $('.ajax-pago').on('submit', function(e) {
                e.preventDefault();

                var $form = $(this);
                var formData = $form.serialize();

                $.ajax({
                    url: $form.attr('action'),
                    method: $form.attr('method'),
                    data: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#alertaSuccess').removeClass('hidden').find('span').text(response
                                .mensaje);
                            $(`.columnaPagar[data-id="${response.id_multa}"]`).addClass(
                                'hidden');
                            $(`.nombreEstado[data-id="${response.id_multa}"]`).text('Pagada');
                        }
                    },

                    error: function(xhr, status, error) {
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                        if (xhr.status == 400) {
                            console.log('abriendo modal');
                            window.toggleModal('modalConfirmacion');
                        }
                    }
                });
            });
        });
    </script>

@endsection
