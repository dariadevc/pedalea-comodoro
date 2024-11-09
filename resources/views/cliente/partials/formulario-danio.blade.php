<h2 class="text-pc-texto-p text-sm border-l-4 border-l-pc-azul pl-2" style="font-size: 24px; margin-bottom: 15px; color: #333;">Seleccione un elemento</h2>
<form id="formulario-danios" class="text-pc-texto-p text-sm border-l-4 border-l-pc-azul pl-2">
    @foreach($elementos as $elemento)
        <div style="margin-bottom: 10px;">
            <label style="font-size: 18px; color: #555;">
                <input type="checkbox" name="elementos[]" value="{{ $elemento['tipo_danio'] }}" class="text-pc-texto-p text-sm border-l-4 border-l-pc-azul pl-2"> {{ $elemento['descripcion'] }}
            </label>
        </div>
    @endforeach
    <button class="py-2 px-4 rounded-full font-semibold bg-slate-50 shadow-md border-4 border-pc-azul" type="button" onclick="continuarACalificarEstaciones()">Seleccionar daños</button>
</form>
