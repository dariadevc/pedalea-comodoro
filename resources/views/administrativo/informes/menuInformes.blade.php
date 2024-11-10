@extends('layouts.administrativo')

@section('nombre_seccion', 'Informes')

@section('contenido')
    <div class="-pt-8 bg-red-500 w-full h-full flex flex-col">
        <div class="hidden md:flex space-x-4 place-self-start">
            <a href="#" class="text-gray-300 hover:text-white">Inicio</a>
            <a href="#" class="text-gray-300 hover:text-white">Servicios</a>
            <a href="#" class="text-gray-300 hover:text-white">Sobre Nosotros</a>
            <a href="#" class="text-gray-300 hover:text-white">Contacto</a>
        </div>
    </div>
    <div class="flex items-center justify-center min-h-screen">
        <div class="text-center">
            <!-- Título del Menú (fuera del contenedor con borde) -->
            <h3 class="text-4xl font-bold mb-8 title-section">Menú de Informes</h3>

            <!-- Contenedor con borde que contiene solo los botones -->
            <div class="border-4 border-sky-500 rounded-lg p-12 max-w-lg w-full mx-auto">
                <!-- Botones -->
                <div class="mb-6">
                    <a href="{{ route('informes.multas') }}" class="btn-uniform">
                        Multas Realizadas
                    </a>
                </div>

                <div class="mb-6">
                    <a href="{{ route('informes.estaciones') }}" class="btn-uniform">
                        Estaciones Utilizadas
                    </a>
                </div>

                <div class="mb-6">
                    <a href="{{ route('informes.rutas') }}" class="btn-uniform">
                        Rutas Utilizadas
                    </a>
                </div>

                <div class="mb-6">
                    <a href="{{ route('informes.tiempoHorario') }}" class="btn-uniform">
                        Alquiler Tiempo/Hora
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
