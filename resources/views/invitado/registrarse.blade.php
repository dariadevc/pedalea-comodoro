@extends('layouts.invitado')

@section('titulo', 'Pedalea Comodoro | Iniciar Sesión')

@section('contenido')
    <section id="login" class="relative flex flex-col items-center justify-center px-10 my-12 h-auto">
        <div
            class="container bg-gray-100 flex flex-col rounded-2xl shadow-lg max-w-4xl p-8 justify-center items-center gap-3 px-8 md:px-16">
            <h2 class="font-bold text-3xl text-pc-azul border-b border-pc-azul py-4">Registrarse</h2>
            <p class="text-sm mt-4 text-pc-texto-p">Si todavia no sos un usuario, creá tu cuenta fácilmente</p>

            {{-- FORMULARIO --}}
            {{-- TODO: Agregar mensajes de error y demás (guiarse con el register que está en auth) --}}
            <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-2 my-5 items-center">
                @csrf

                {{-- INFORMACIÓN PERSONAL --}}
                <fieldset class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <legend class="font-semibold text-lg">Información Personal</legend>
                    <div class="flex flex-col gap-2">
                        <label for="nombre" :value="__('Name')">Nombre</label>
                        <input class="p-2 rounded-xl border shadow-sm" type="text" name="nombre" id='nombre'
                            placeholder="Jane" :value="old('name')" required autofocus autocomplete="name">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="apellido">Apellido</label>
                        <input class="p-2 rounded-xl border shadow-sm" type="text" name="apellido" id='apellido'
                            placeholder="Doe" :value="old('family-name')" required autocomplete="family-name">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="dni">DNI</label>
                        <input class="p-2 rounded-xl border shadow-sm" type="number" name="dni" id="dni"
                            placeholder="43719784" required autocomplete="">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                        <input class="p-2 rounded-xl border shadow-sm" type="date" name="fecha_nacimiento"
                            id="fecha_nacimiento" required autocomplete="bday">
                    </div>
                </fieldset>
                <hr class="my-5">

                {{-- INFORMACIÓN DE CONTACTO --}}
                <fieldset class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <legend class="font-semibold text-lg">Información de Contacto</legend>
                    <div class="flex flex-col gap-2">
                        <label for="email">Email</label>
                        <input class="p-2 rounded-xl border shadow-sm" type="email" name="email" id="email"
                            placeholder="miemail@gmail.com" required autocomplete="email">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="celular">Número de Celular</label>
                        <input class="p-2 rounded-xl border shadow-sm" type="tel" name="celular" id="celular"
                            placeholder="2974148635" required autocomplete="tel">
                    </div>
                </fieldset>
                <hr class="my-5">

                {{-- INFORMACIÓN DE INICIO DE SESIÓN --}}
                {{-- TODO: Hay que hacer funcionar la verificación acá --}}
                <fieldset class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <legend class="font-semibold text-lg">Información de Inicio de Sesión</legend>
                    <div class="flex flex-col gap-2">
                        <label for="contrasenia">Ingrese su contraseña</label>
                        <input class="p-2 rounded-xl border shadow-sm" type="password" name="contrasenia" id="contrasenia"
                            required>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="contrasenia_verif">Confirme su contraseña</label>
                        <input class="p-2 rounded-xl border shadow-sm" type="password" name="contrasenia_verif"
                            id="contrasenia_verif" required>
                    </div>
                </fieldset>

                <button
                    class="btn bg-slate-50 text-pc-azul rounded-full px-6 py-3 mt-5 uppercase hover:bg-pc-azul hover:text-slate-50 outline outline-4 -outline-offset-4 outline-pc-azul max-w-72"
                    type="submit">Registrarse</button>
            </form>

            <div class="mt-5 flex justify-between items-center gap-10 border-t border-pc-rojo py-4">
                <p class="text-sm text-pc-texto-p">¿Ya tenes una cuenta?</p>
                <button
                    class="shadow-md py-2 px-5 rounded-full transition duration-500 font-semibold text-xs uppercase bg-slate-50 border outline outline-4 -outline-offset-4 outline-pc-rojo text-pc-rojo hover:bg-pc-rojo hover:text-slate-50"><a
                        href="{{ route('iniciar_sesion') }}">Iniciá Sesión</a></button>
            </div>
        </div>
    </section>

@endsection
