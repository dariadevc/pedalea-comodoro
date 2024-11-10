@extends("layouts.invitado")

@section('titulo', 'Pedalea Comodoro | Recuperar Contraseña')

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
    {{-- <div class="">
        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>
    
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <p>hola</p>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
    
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
    
            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('Email Password Reset Link') }}
                </x-primary-button>
            </div>
        </form>
    </div> --}}

    <section id="iniciarSesion" class="relative flex flex-col items-center justify-center px-10 my-20 h-auto">
        <div
            class="md:w-2/3 bg-gray-00 flex rounded-2xl shadow-lg max-w-4xl p-8 justify-center items-center sm:items-center sm:justify-start gap-3">
            <div class=" px-8 md:px-16 ">
                <h2 class="font-bold text-3xl text-pc-rojo border-b border-pc-rojo py-4">Recuperar Contraseña</h2>
                <p class="text-sm mt-4 text-pc-texto-p">¿Olvidaste tu contraseña? No hay problema.</p>
                <p class="text-sm mt-1 text-pc-texto-p">Hacenos saber tu correo electrónico y te vamos a enviar un enlace para elegir una nueva contraseña.</p>

                {{-- FORMULARIO --}}
                {{-- TODO: Agregar mensajes de error y demás (guiarse con el login que está en auth) --}}
                <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-4">
                    @csrf

                    {{-- EMAIL --}}
                    <div>
                        <x-text-input id='email' type="email" name="email" placeholder="Correo Electrónico" required
                            autofocus autocomplete="email" class="mt-8" />
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <x-btn-rojo-blanco type="submit" class="max-w-80 place-self-center" >Reestablecer contraseña</x-btn-rojo-blanco>
                </form>

                <div class="mt-8 flex justify-between items-center gap-3 border-t-2 pt-5">
                    <p class="text-sm text-pc-texto-p">¿Todavía no tenes una cuenta?</p>
                    <a href="{}"></a>
                    <a href="{{ route('registrarse') }}">
                        <x-btn-azul-blanco class="text-xs">{{ 'Registrate' }}</x-btn-rojo-blanco>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection