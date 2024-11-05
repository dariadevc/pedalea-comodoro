@extends('layouts.app-blade')

@section('content')
    <h1 class="text-2xl font-bold mb-6 bg-white">Panel Administrativo</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold">Bicicletas</h2>
            <p class="mt-2">Gestiona las bicicletas del sistema.</p>
            <div class="mt-4">
                <a href="{{ route('bicicletas.index') }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ver todas las bicicletas</a>
                <a href="{{ route('bicicletas.create') }}"
                    class="ml-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Agregar bicicleta</a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold">Estaciones</h2>
            <p class="mt-2">Gestiona las estaciones del sistema.</p>
            <div class="mt-4">
                <a href="{{ route('estaciones.index') }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ver todas las estaciones</a>
                <a href="{{ route('estaciones.create') }}"
                    class="ml-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Agregar estación</a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold">Tarifa</h2>
            <p class="mt-2">Gestiona la tarifa actual del sistema.</p>
            <div class="mt-4">
                <a href="{{ route('administrativo.editTarifa') }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ver tarifa actual</a>
            </div>
        </div>
        {{--VOY A TRATAR DE HACER QUE QUEDE UN BOTON SOLO PARA LOS INFORMES Y QUE DE AHI TE MANDE A UN MENU DE OPCIONES(UNA NUEVA VISTA PARA EL MENU)
        EN EL QUE SE PUEDE SELECCIONAR QUE INFORME QUIERE REALIZAR--}}
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold">Informe Multas</h2>
            <p class="mt-2">Gestiona los informes de multas.</p>
            <div class="mt-4">
                <a href="{{ route('informes.multas') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ver informes de multas</a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold">Informe Estaciones</h2>
            <p class="mt-2">Gestiona los informes de estaciones.</p>
            <div class="mt-4">
                <a href="{{ route('informes.estaciones') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ver informes de estaciones</a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold">Informe Rutas</h2>
            <p class="mt-2">Gestiona los informes de rutas utilizadas.</p>
            <div class="mt-4">
                <a href="{{ route('informes.rutas') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ver informes de rutas utilizadas</a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold">Informe Alquileres</h2>
            <p class="mt-2">Gestiona los informes de Tiempo/Horario de Alquileres mas utilizados.</p>
            <div class="mt-4">
                <a href="{{ route('informes.tiempoHorario') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ver informes de Alquileres</a>
            </div>
        </div>
    </div>

@endsection
