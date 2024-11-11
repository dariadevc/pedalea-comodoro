@extends('layouts.cliente')

@section('nombre_seccion', 'Perfil')

@section('contenido')
    <div class="p-6 bg-white shadow rounded-lg">
        <h2 class="text-2xl font-bold text-gray-700 mb-4">Perfil</h2>
        <div class="space-y-4">
            <div class="flex items-center">
                <span class="font-medium text-gray-600 w-48">Nombre</span>
                <span class="text-gray-700">{{ $usuario->nombre }}</span>
            </div>
            <div class="flex items-center">
                <span class="font-medium text-gray-600 w-48">Apellido</span>
                <span class="text-gray-700">{{ $usuario->apellido }}</span>
            </div>
            <div class="flex items-center">
                <span class="font-medium text-gray-600 w-48">Email</span>
                <span class="text-gray-700">{{ $usuario->email }}</span>
            </div>
            <div class="flex items-center">
                <span class="font-medium text-gray-600 w-48">Fecha de Nacimiento</span>
                <span class="text-gray-700">{{ $cliente->fecha_nacimiento }}</span>
            </div>
            <div class="flex items-center">
                <span class="font-medium text-gray-600 w-48">Saldo</span>
                <span class="text-gray-700">${{ $cliente->saldo }}</span>
            </div>
            <div class="flex items-center">
                <span class="font-medium text-gray-600 w-48">Puntaje Actual</span>
                <span class="text-red-500 font-semibold">{{ $cliente->puntaje }}</span>
            </div>
        </div>
    </div>
    
    
@endsection
