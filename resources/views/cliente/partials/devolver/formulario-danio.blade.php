<p class="text-pc-texto-p text-lg border-l-4 border-l-pc-azul pl-2 mb-3">Seleccione un daño</p>
<form id="formularioDanios" action="{{ route('devolver.guardar-danios') }}" method="POST" class="flex flex-col gap-3 p-4 shadow-md rounded-xl border border-pc-azul bg-white">cliente.reservas
    @csrf
    @foreach ($danios as $danio)
        <div class="flex items-center gap-2">
            <input type="checkbox" name="elementos[]" value="{{ $danio->id_danio }}" class="w-4 h-4 text-pc-azul border-gray-300 focus:ring-pc-azul">
            <label class="text-base text-gray-700">{{ $danio->descripcion }}</label>
        </div>
    @endforeach
    <button class="mt-4 py-2 px-6 rounded-full font-semibold bg-slate-50 shadow-md border-4 border-pc-azul text-pc-azul hover:bg-pc-azul hover:text-white transition duration-300" type="button" onclick="guardarDanios(event)">
        Confirmar  daños
    </button>
    <div id="error-danios" class="error-message text-black-500 text-sm border-l-4 border-l-pc-rojo pl-2 hidden mt-2"></div>
</form>
