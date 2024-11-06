@extends('layouts.invitado')

@section('titulo', 'Pedalea Comodoro | Iniciar Sesión')

@section('header')
    <div class="container flex flex-1 justify-center items-center">
        <a href="{{ route('landing') }}" class="px-2">
            <div class="py-1 flex items-center gap-4 text-slate-50 uppercase text-sm font-semibold">
                <img src="{{ asset('img/bicicleta_blanca.png') }}" alt="" class="h-14">
                <h2 class="">Pedalea Comodoro</h2>
            </div>
        </a>
    </div>
@endsection

@section('contenido')
    <section id="iniciarSesion" class="relative flex flex-col items-center justify-center px-10 my-12 h-auto">
        <div
            class="container bg-gray-100 flex rounded-2xl shadow-lg max-w-4xl p-8 justify-center items-center sm:items-center sm:justify-start gap-3">
            <div class="md:w-1/2 px-8 md:px-16 ">
                <h2 class="font-bold text-3xl text-pc-rojo border-b border-pc-rojo py-4">Iniciar Sesión</h2>
                <p class="text-sm mt-4 text-pc-texto-p">Si ya sos un usuario, ingresá a tu cuenta fácilmente</p>

                {{-- FORMULARIO --}}
                {{-- TODO: Agregar mensajes de error y demás (guiarse con el login que está en auth) --}}
                <form method="POST" action="{{ route('iniciar_sesion') }}" class="flex flex-col gap-4">
                    @csrf

                    {{-- EMAIL --}}
                    <div>
                        <x-text-input id='email' type="email" name="email" placeholder="Correo Electrónico" required
                            autofocus autocomplete="email" class="mt-8" />
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- CONTRASEÑA --}}
                    <div class="relative">
                        <x-text-input id="password" type="password" name="password" placeholder="Contraseña" required
                            autocomplete="current-password" />
                        {{-- TODO: Agregar opción que te permita ver la contraseña (con el icono del ojito) --}}
                        @error('password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <x-btn-rojo-blanco type="submit">{{ 'Iniciar Sesión' }}</x-btn-rojo-blanco>
                </form>

                {{-- TODO: Agregar enlace con vista de recuperar contraseña --}}
                <div class="mt-5 border-b border-pc-azul py-4">
                    <a href="{{ route('password.request') }}"
                        class="text-pc-texto-p text-sm hover:text-pc-naranja">¿Olvidaste tu contraseña?</a>
                </div>

                <div class="mt-3 flex justify-between items-center gap-3">
                    <p class="text-sm text-pc-texto-p">¿Todavía no tenes una cuenta?</p>
                    <a href="{}"></a>
                    <a href="{{ route('registrarse') }}">
                        <x-btn-azul-blanco class="text-xs">{{ 'Registrate' }}</x-btn-rojo-blanco>
                    </a>
                </div>
            </div>

            <div class="sm:block hidden w-1/2 ">
                <img src="/img/bicicleta_login.jpg" alt="" class="rounded-2xl ">
            </div>
        </div>
    </section>
@endsection
