@extends('layouts.administrativo')

@section('nombre_seccion', 'Estaciones')

@section('contenido')
    <div class="w-full 2xl:w-2/3 flex flex-col">
        @if (session('success'))
            <div class="alert alert-success bg-pc-azul text-white rounded-md p-4 mb-2 font-semibold text-center text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger bg-pc-rojo text-white rounded-md p-4 mb-2 font-semibold text-center text-sm">
                {{ session('error') }}
            </div>
        @endif

        <a href="{{ route('estaciones.create') }}"
            class="shadow-md py-3 px-6 rounded-full transition duration-500 font-semibold uppercase bg-slate-50 outline outline-4 -outline-offset-4 outline-pc-rojo text-pc-rojo hover:bg-pc-rojo hover:text-slate-50 w-80 place-self-center mb-4 text-center">
            Agregar Nueva Estación
        </a>

        <table class="min-w-full border-collapse block md:table rounded-2xl md:shadow-md overflow-hidden">
            <thead class="block md:table-header-group">
                <tr
                    class="border border-grey-600 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto md:relative">
                    <th
                        class="bg-gray-50 p-2 text-pc-texto-h font-bold md:border md:border-grey-600 text-left block md:table-cell">
                        Nombre</th>
                    <th
                        class="bg-gray-50 p-2 text-pc-texto-h font-bold md:border md:border-grey-600 text-left block md:table-cell">
                        Estado</th>
                    <th
                        class="bg-gray-50 p-2 text-pc-texto-h font-bold md:border md:border-grey-600 text-left block md:table-cell">
                        Cant. Bicicletas Actuales</th>
                    <th
                        class="bg-gray-50 p-2 text-pc-texto-h font-bold md:border md:border-grey-600 text-left block md:table-cell">
                        Calificación</th>
                    <th
                        class="bg-gray-50 p-2 text-pc-texto-h font-bold md:border md:border-grey-600 text-left block md:table-cell">
                        Acciones</th>
                </tr>
            </thead>
            <tbody class="block md:table-row-group">
                @foreach ($estaciones as $estacion)
                    <tr
                        class="bg-gray-50 border border-grey-600 my-2 rounded-xl shadow-sm md:border-none block md:table-row">
                        <td class="p-2 md:border md:border-grey-600 text-left block md:table-cell">
                            <span class="inline-block w-1/3 md:hidden font-bold">Nombre</span>
                            {{ $estacion->nombre }}
                        </td>
                        <td class="p-2 md:border md:border-grey-600 text-left block md:table-cell">
                            <span class="inline-block w-1/3 md:hidden font-bold">Estado</span>
                            <span
                                class="inline-flex items-center gap-1 rounded-full 
                        {{ $estacion->id_estado == '1' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }} 
                        px-2 py-1 text-xs font-semibold">
                                <span
                                    class="h-1.5 w-1.5 rounded-full {{ $estacion->id_estado == '1' ? 'bg-green-600' : 'bg-red-600' }}">
                                </span>
                                {{ ucfirst($estacion->estado->nombre) }}
                            </span>
                        </td>
                        <td class="p-2 md:border md:border-grey-600 text-left block md:table-cell">
                            <span class="inline-block w-1/3 md:hidden font-bold">Cant. Bicicletas Actuales</span>
                            {{ $estacion->bicicletas_count }}
                        </td>
                        <td class="p-2 md:border md:border-grey-600 text-left block md:table-cell">
                            <span class="inline-block w-1/3 md:hidden font-bold">Calificación</span>
                            {{ $estacion->calificacion }} / 5
                        </td>
                        <td class="p-2 md:border md:border-grey-600 text-left block md:table-cell">
                            <span class="inline-block w-1/3 md:hidden font-bold">Acciones</span>
                            @if ($estacion->en_reserva_retiro || $estacion->en_reserva_devolucion)
                                <button type="button"
                                    class="bg-gray-400 text-white font-bold py-1 px-2 border border-gray-400 rounded">Editar</button>
                                <button type="button"
                                    class="bg-gray-400 text-white font-bold py-1 px-2 border border-gray-400 rounded ml-2">Deshabilitar</button>
                                <button type="button"
                                    class="bg-gray-400 text-white font-bold py-1 px-2 border border-gray-400 rounded ml-2">Eliminar</button>
                            @else
                                <a href="{{ route('estaciones.edit', $estacion->id_estacion) }}"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 border border-blue-500 rounded">Editar</a>
                                <form action="{{ route('estaciones.cambiar-estado', $estacion->id_estacion) }}"
                                    method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="estado" value="{{ $estacion->id_estado }}">
                                    @if ($estacion->id_estado == 1)
                                        <button type="submit"
                                            class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-1 px-2 border border-orange-500 rounded ml-2">Deshabilitar</button>
                                    @else
                                        <button type="submit"
                                            class="bg-green-600 hover:bg-green-700 text-white font-bold py-1 px-2 border border-green-600 rounded ml-2">Habilitar</button>
                                    @endif
                                </form>
                                <button type="button"
                                    onclick="mostrarModalEliminar({{ $estacion->id_estacion }}, '{{ $estacion->nombre }}')"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 border border-red-500 rounded ml-2">
                                    Eliminar
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal de Confirmación -->
    <div id="modalEliminar" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 invisible">
        <div class="bg-white p-6 rounded-lg shadow-lg w-11/12 sm:w-1/3">
            <h2 class="text-lg font-semibold text-gray-700 mb-4 text-center">
                ¿Estás seguro de que deseas eliminar la estación <span id="nombreEstacion" class="font-bold"></span>?
            </h2>
            <div class="flex gap-4 justify-center">
                <form id="formEliminar" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="shadow-md py-3 px-6 rounded-full transition duration-500 font-semibold uppercase bg-red-600 text-white hover:bg-red-700">
                        Sí, eliminar
                    </button>
                </form>
                <button type="button" onclick="cerrarModal()"
                    class="shadow-md py-3 px-6 rounded-full transition duration-500 font-semibold uppercase bg-gray-300 hover:bg-gray-400">
                    Cancelar
                </button>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function mostrarModalEliminar(id, nombre) {
            const modal = document.getElementById('modalEliminar');
            const form = document.getElementById('formEliminar');
            const nombreEstacion = document.getElementById('nombreEstacion');

            form.action = `/estaciones/${id}`;
            nombreEstacion.textContent = nombre;

            modal.classList.remove('invisible');
        }


        function cerrarModal() {
            document.getElementById('modalEliminar').classList.add('invisible');
        }
    </script>
@endsection
