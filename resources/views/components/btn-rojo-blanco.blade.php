{{-- Botón usado principalmente para lo relacionado al inicio de sesión. --}}
{{-- Se puede usar adentro de un href para que ya le quede el formato del btón, o agregarle type="submit" para usarlo en formularios, ejemplo en la vista de registrarse. --}}

<button
    {{ $attributes->merge(['class' => 'shadow-md py-3 px-6 rounded-full transition duration-500 font-semibold uppercase bg-slate-50 outline outline-4 -outline-offset-4 outline-pc-rojo text-pc-rojo hover:bg-pc-rojo hover:text-slate-50']) }}>
    {{-- Contenido del botón --}}
    {{ $slot }}
</button>
