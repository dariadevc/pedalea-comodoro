{{-- cliente/partials/devolver/consulta-danios.blade.php --}}
<div id="contenedorConsultaDanios" class="flex flex-col gap-4">
    <div>
        <p class="text-pc-texto-p text-lg border-l-4 border-l-pc-azul pl-2">¿La bicicleta recibió daños?</p>
    </div>
    <div class="flex gap-6 self-center">
        <form id="formularioMostrarDanios" action="{{ route('devolver.mostrar-danios') }}" method="POST">
            @csrf
            <button class="py-2 w-20 rounded-full font-semibold bg-slate-50 shadow-md border-4 border-pc-azul" onclick="mostrarFormularioDanios(event)">Sí</button>
        </form>
        <form id="formularioSinDanios" action="{{ route('devolver.sin-danios') }}" method="POST">
            @csrf
            <button class="py-2 w-20 rounded-full font-semibold bg-slate-50 shadow-md border-4 border-pc-azul" onclick="sinDanios(event)">No</button>
        </form>
    </div>
</div> 