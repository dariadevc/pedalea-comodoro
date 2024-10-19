@extends('layouts.invitado')

@section('titulo', 'Pedalea Comodoro | Iniciar Sesión')

@section('contenido')
    <section id="login" class="relative flex flex-col items-center justify-center px-10 my-12 h-auto">
        <div
            class="container bg-gray-100 flex rounded-2xl shadow-lg max-w-4xl p-8 justify-center items-center sm:items-center sm:justify-start gap-3">
            <div class="md:w-1/2 px-8 md:px-16 ">
                <h2 class="font-bold text-3xl text-pc-rojo border-b border-pc-rojo py-4">Iniciar Sesión</h2>
                <p class="text-sm mt-4 text-pc-texto-p">Si ya sos un usuario, ingresá a tu cuenta fácilmente</p>

                {{-- FORMULARIO --}}
                {{-- TODO: Agregar mensajes de error y demás (guiarse con el login que está en auth) --}}
                <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4">
                    @csrf

                    {{-- EMAIL --}}
                    <div>
                        <input class="p-2 mt-8 rounded-xl border w-full shadow-sm" id='email' type="email"
                            name="email" " placeholder="Correo Electrónico" required autofocus autocomplete="email">
                                </div>

                                {{-- CONTRASEÑA --}}
                                <div class="relative">
                                    <input class="p-2 rounded-xl border w-full shadow-sm" id="password" type="password" name="contrasenia" placeholder="Contraseña" required autocomplete="current-password">
                                    {{-- TODO: Agregar opción que te permita ver la contraseña (con el icono del ojito) --}}
                                </div>
                                <button class="btn bg-slate-50 text-pc-rojo rounded-full px-6 py-3 uppercase hover:bg-pc-rojo hover:text-slate-50 outline outline-4 -outline-offset-4 outline-pc-rojo" type="submit">Iniciar Sesión</button>
                            </form>

                            {{-- TODO: Agregar enlace con vista de recuperar contraseña --}}
                            <div class="mt-5 border-b border-pc-azul py-4">
                                <a href="" class="text-pc-texto-p text-sm hover:text-pc-naranja">¿Olvidaste tu contraseña?</a>
                            </div>

                            <div class="mt-3 flex justify-between items-center gap-3">
                                <p class="text-sm text-pc-texto-p">¿Todavía no tenes una cuenta?</p>
                                <button class="shadow-md py-2 px-5 rounded-full transition duration-500 font-semibold text-xs uppercase bg-slate-50 border outline outline-4 -outline-offset-4 outline-pc-azul text-pc-azul hover:bg-pc-azul hover:text-slate-50">
                                    <a href="{{ route('registrarse') }}">Registrate</a>
                                </button>
                            </div>
                        </div>

                        <div class="sm:block hidden w-1/2 ">
                            <img src="/img/bicicleta_login.jpg" alt="" class="rounded-2xl ">
                        </div>
                    </div>
                </section>
@endsection
