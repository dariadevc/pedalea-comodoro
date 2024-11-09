{{-- partials/devolucion-bicicleta.blade.php --}}
<div class="flex flex-col gap-4">
    <div>
        <p id="mensajeDevolucion" class="text-pc-texto-p text-sm border-l-4 border-l-pc-azul pl-2">¡Ya puedes devolver tu bicicleta!</p>
    </div>
    <div class="flex gap-6 self-center">
        <button hidden onclick="devolver()" id="botonDevolver" class="py-2 px-4 rounded-full font-semibold bg-slate-50 shadow-md border-4 border-pc-azul">Devolver Bicicleta</button>
    </div>
</div>
