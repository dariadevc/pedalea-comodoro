{{-- partials/formulario-calificacion.blade.php --}}
<form id="formCalif" class="mt-4">
    <div class="flex flex-col gap-4">
        <div>
            <p class="text-pc-texto-p text-sm border-l-4 border-l-pc-azul pl-2">Califique la Estación</p>
        </div>
        <div id="calificacion" class="bg-gradient-to-br from-pc-celeste to-pc-azul p-4 shadow-md rounded-xl flex flex-col gap-6 w-full">
            @for ($i = 1; $i <= 5; $i++)
                <div class="estrella" data-valor="{{ $i }}">
                    <svg width="40px" height="40px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.2691...Z" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
            @endfor
        </div>
    </div>
    <button hidden id="idEnviar" type="submit" class="bg-blue-500 text-white px-4 py-2 mt-4 rounded">Enviar Calificación</button>
    <input type="hidden" name="calificacion" id="inputCalificacion">
</form>
