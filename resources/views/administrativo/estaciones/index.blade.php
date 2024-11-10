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
                            <a href="{{ route('estaciones.edit', $estacion->id_estacion) }}"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 border border-blue-500 rounded">Editar</a>
                            <form action="{{ route('estaciones.destroy', $estacion->id_estacion) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 border border-red-500 rounded ml-2">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
