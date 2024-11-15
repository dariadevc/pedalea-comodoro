@extends('layouts.inspector')

@section('titulo', 'Inspector')

@section('nombre_seccion', 'Panel Inspector')

@section('contenido')
    <div class="flex flex-col items-center gap-1">

        <img src="img/bicicleta.png" alt="" class="h-14 w-14">
        <p class="text-xl font-semibold text-pc-texto-h">¡Hola <span class="font-bold text-pc-rojo">
                {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</span>!</p>
    </div>
    <div class="grid grid-cols-2 gap-6">
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
        <a class=" bg-gray-50 w-full h-36 p-4 shadow-md rounded-xl flex flex-col items-center gap-1"
            href="{{ route('inspector.bicicletas') }}">
            <img src="img/bicicleta.png" alt="" class="h-14 w-14">
            <h3 class="text-center text-pc-texto-h semibol">Deshabilitar las bicicletas</h3>
        </a>

        <a class=" bg-gray-50 w-full h-36 p-4 shadow-md rounded-xl flex flex-col items-center gap-1"
            href="{{ route('inspector.infraccion') }}">
            <svg width="50px" height="50px" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg"
                class="mt-1">
                <path
                    d="M22.0098 12.39V7.39001C22.0098 6.32915 21.5883 5.31167 20.8382 4.56152C20.0881 3.81138 19.0706 3.39001 18.0098 3.39001H6.00977C4.9489 3.39001 3.93148 3.81138 3.18134 4.56152C2.43119 5.31167 2.00977 6.32915 2.00977 7.39001V17.39C2.00977 18.4509 2.43119 19.4682 3.18134 20.2184C3.93148 20.9685 4.9489 21.39 6.00977 21.39H12.0098"
                    stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M21.209 5.41992C15.599 16.0599 8.39906 16.0499 2.78906 5.41992" stroke="#000000" stroke-width="1.5"
                    stroke-linecap="round" stroke-linejoin="round" />
                <path d="M15.0098 18.39H23.0098" stroke="#000000" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path d="M20.0098 15.39L23.0098 18.39L20.0098 21.39" stroke="#000000" stroke-width="1.5"
                    stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <h3 class="text-center">Generar infracciones</h3>
        </a>
    </div>
    <div class="p-8 place-self-center">

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="text-center text-base py-2 px-4 text-pc-texto-h font-medium rounded-full bg-gray-200 hover:bg-white hover:shadow-md my-1">
                {{ __('Log Out') }}
            </button>
        </form>

    </div>
@endsection
