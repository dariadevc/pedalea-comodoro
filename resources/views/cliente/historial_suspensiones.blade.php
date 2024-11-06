@extends('layouts.cliente')

@section('nombre_seccion', 'Multas')

@section('contenido')
    <div class="flex flex-col w-full md:w-3/4 gap-4">
        {{-- BUSCAR --}}
        <section class="flex gap-2 bg-gray-50 py-2 px-6 rounded-full text-sm items-center border-2">
            <p>icono</p>
            {{-- ? Debería usar un form para el buscador? Qué puede buscar? --}}
            <input role="combobox" aria-autocomplete="list" aria-expanded="false" autocomplete="off"
                aria-label="Buscar actividad" type="text"
                class="text-sm border-none bg-gray-50 focus:outline-none focus:ring-0 w-full" placeholder="Buscar..."
                inputvalue="" value="">
            {{-- TODO: Que funcione el buscador ¿Bajo qué criterio? --}}
            <x-btn-rojo-blanco type="submit" class="capitalize">Buscar</x-btn-rojo-blanco>
        </section>
        {{-- FILTRAR --}}
        <section class="flex bg-gray-50 p-4 justify-between items-center text-sm rounded-md shadow-sm">
            {{-- FILTROS --}}
            <div class="flex gap-2">
                <div>
                    <button class="flex gap-4 items-center px-2 py-1" type="button">
                        <span class="">Período</span>
                        <x-icon-flecha-abajo-oscura width="15px" height="15px" />
                    </button>
                    {{-- TODO: Agregar dropdown --}}
                </div>
                <div>
                    <button class="flex gap-4 items-center px-2 py-1" type="button">
                        <span class="">Estados</span>
                        <x-icon-flecha-abajo-oscura width="15px" height="15px" />
                    </button>
                    {{-- TODO: Agregar dropdown --}}
                </div>
            </div>
            {{-- BORRAR FILTROS --}}
            {{-- TODO: Hacer que borre los filtros (O los setee en default) se tiene que habilitar solo cuando el usuario elige filtros --}}
            <div>
                <button type="button" class="text-gray-400">Borrar filtros</button>
            </div>
        </section>
        {{-- HISTORIAL --}}
        <section class="grid
                            auto-rows-max gap-2 bg-gray-50 rounded-xl shadow-md">
            {{-- LISTA DE MULTAS --}}
            {{-- TODO: Actualizar tarjetas a medida que realiza nuevas reservas, cada href vincula a la reserva/alquiler correspondiente --}}
            {{-- TODO: Agrupar las reservas/alquileres por fecha --}}
            <ul class="">
                <li class="flex box-border">
                    <a href="#" class="p-4 hover:bg-gray-100 w-full">
                        {{-- INFO DE LA ACTIVIDAD --}}
                        <div class="flex flex-col gap-1 items-start">
                            <h2>Suspensión</h2>
                            <p>Finalizada</p>
                        </div>
                    </a>
                </li>
            </ul>
        </section>
    </div>
@endsection

@section('scripts')
@endsection
