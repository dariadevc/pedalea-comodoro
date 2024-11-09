{{-- partials/consulta-danios.blade.php --}}
<div id="contenedorConsultaDanios" class="flex flex-col gap-4">
    <div>
        <p id="mensajeDanios" class="text-pc-texto-p text-sm border-l-4 border-l-pc-azul pl-2">¿La bicicleta recibió daños?</p>
    </div>
    <div class="flex gap-6 self-center">
        <form action="{{ route('devolver.mostrar-danios') }}"></form>
        <button id="btnSi" class="py-2 w-20 rounded-full font-semibold bg-slate-50 shadow-md border-4 border-pc-azul" onclick="mostrarFormularioDanios()">Sí</button>
        <button id="btnNo" class="py-2 w-20 rounded-full font-semibold bg-slate-50 shadow-md border-4 border-pc-azul">No</button>
    </div>
</div>
