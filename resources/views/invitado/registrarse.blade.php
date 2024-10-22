@extends('layouts.invitado')

@section('titulo', 'Pedalea Comodoro | Iniciar Sesión')

@section('contenido')
    <section id="registrarse" class="relative flex flex-col items-center justify-center px-10 my-12 h-auto">
        <div
            class="container bg-gray-100 flex flex-col rounded-2xl shadow-lg max-w-4xl p-8 justify-center items-center gap-3 px-8 md:px-16">
            <h2 class="font-bold text-3xl text-pc-azul border-b border-pc-azul py-4">Registrarse</h2>
            <p class="text-sm mt-4 text-pc-texto-p">Si todavia no sos un usuario, creá tu cuenta fácilmente</p>

            {{-- FORMULARIO --}}
            {{-- TODO: Agregar mensajes de error y demás (guiarse con el register que está en auth) --}}
            <form method="POST" action="{{ route('registrarse') }}" class="flex flex-col gap-8 my-5 items-center">
                @csrf

                {{-- INFORMACIÓN PERSONAL --}}
                <fieldset class="grid grid-cols-1 sm:grid-cols-2 gap-6 border-t-2 border-pc-azul">
                    <legend class="font-semibold text-lg pr-2 text-pc-texto-h my-4">Información Personal</legend>
                    <div class="flex flex-col gap-2">
                        <label for="nombre">Nombre</label>
                        <x-text-input type="text" name="nombre" id='nombre' placeholder="Jane"
                            value="{{ old('nombre') }}" required autofocus autocomplete="nombre" />
                        @error('nombre')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="apellido">Apellido</label>
                        <x-text-input type="text" name="apellido" id='apellido' placeholder="Doe"
                            value="{{ old('apellido') }}" required autocomplete="apellido" />
                        @error('apellido')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="dni">DNI</label>
                        <x-text-input type="number" name="dni" id="dni" placeholder="43719784"
                            value="{{ old('dni') }}" required autocomplete="dni" />
                        @error('dni')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                        <x-text-input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
                            value="{{ old('fecha_nacimiento') }}" required autocomplete="fecha_nacimiento" />
                    </div>
                </fieldset>

                {{-- INFORMACIÓN DE CONTACTO --}}
                <fieldset class="grid grid-cols-1 sm:grid-cols-2 gap-6 border-t-2 border-pc-azul">
                    <legend class="font-semibold text-lg pr-2 text-pc-texto-h my-4">Información de Contacto</legend>
                    <div class="flex flex-col gap-2">
                        <label for="email">Email</label>
                        <x-text-input type="email" name="email" id="email" placeholder="miemail@gmail.com"
                            value="{{ old('email') }}" required autocomplete="email" />
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="celular">Número de Celular</label>
                        <x-text-input type="tel" name="numero_telefono" id="numero_telefono" placeholder="+542974148635"
                            value="{{ old('numero_telefono') }}" required autocomplete="numero_telefono" />
                        @error('numero_telefono')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </fieldset>

                {{-- INFORMACIÓN DE INICIO DE SESIÓN --}}
                {{-- TODO: Hay que hacer funcionar la verificación acá --}}
                <fieldset class="grid grid-cols-1 sm:grid-cols-2 gap-6 border-t-2 border-pc-azul">
                    <legend class="font-semibold text-lg pr-2 text-pc-texto-h my-4">Información de Inicio de Sesión</legend>
                    <div class="flex flex-col gap-2">
                        <label for="password">Ingrese su contraseña</label>
                        <x-text-input type="password" name="password" id="password" required />
                        @error('password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="password_confirmation">Confirme su contraseña</label>
                        <x-text-input type="password" name="password_confirmation" id="password_confirmation" required />
                        @error('password_confirmation')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </fieldset>

                <x-btn-azul-blanco type="submit">{{ 'Registrarse' }}</x-btn-azul-blanco>
            </form>

            <div class="mt-5 flex justify-between items-center gap-10 border-t border-pc-rojo py-4">
                <p class="text-sm text-pc-texto-p">¿Ya tenes una cuenta?</p>
                <a href="{{ route('iniciar-sesion') }} ">
                    <x-btn-rojo-blanco class="text-xs">{{ 'Iniciá Sesión' }}</x-btn-rojo-blanco>
                </a>
            </div>
        </div>
    </section>

@endsection
