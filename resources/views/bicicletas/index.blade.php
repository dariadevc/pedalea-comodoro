@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6 text-white">Lista de Bicicletas</h1>

    @if (session('success'))
        <div class="alert alert-success mb-4 text-white">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger text-white">
            {{ session('error') }}
        </div>
    @endif

    <a href="{{ route('bicicletas.create') }}"
        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mb-4">Agregar Nueva Bicicleta</a>

    <table class="min-w-full border-collapse block md:table">
        <thead class="block md:table-header-group">
            <tr
                class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto  md:relative ">
                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                    ID</th>
                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                    Patente</th>
                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                    Estado</th>
                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                    Estación Actual</th>
                <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                    Acciones</th>
            </tr>
        </thead>
        <tbody class="block md:table-row-group">
            @foreach ($bicicletas as $bicicleta)
                <tr class="bg-gray-300 border border-grey-500 md:border-none block md:table-row">
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                        <span class="inline-block w-1/3 md:hidden font-bold">ID</span>
                        {{ $bicicleta->id_bicicleta }}
                    </td>
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                        <span class="inline-block w-1/3 md:hidden font-bold">ID</span>
                        {{ $bicicleta->patente }}
                    </td>
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                        <span
                            class="inline-flex items-center gap-1 rounded-full 
                        {{ $bicicleta->id_estado == '1' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }} 
                        px-2 py-1 text-xs font-semibold">
                            <span
                                class="h-1.5 w-1.5 rounded-full {{ $bicicleta->id_estado == '1' ? 'bg-green-600' : 'bg-red-600' }}">
                            </span>
                            {{ ucfirst($bicicleta->estado->nombre) }}
                        </span>
                    </td>
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                        <span class="inline-block w-1/3 md:hidden font-bold">Estación Actual</span>
                        {{ $bicicleta->estacionActual ? $bicicleta->estacionActual->nombre : 'Sin estacion' }}
                    </td>
                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                        <span class="inline-block w-1/3 md:hidden font-bold">Acciones</span>
                        <a href="{{ route('bicicletas.edit', $bicicleta->id_bicicleta) }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 border border-blue-500 rounded">Editar</a>
                        <form action="{{ route('bicicletas.destroy', $bicicleta->id_bicicleta) }}" method="POST"
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
@endsection