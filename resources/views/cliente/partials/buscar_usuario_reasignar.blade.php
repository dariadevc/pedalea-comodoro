<button cerrar_tarjeta_reasignar @click="mostrarBusqueda = false" class="place-self-end"><x-icon-cruz-oscura height="25px"
        width="25px" /></button>
<h2 class="font-semibold text-pc-texto-h place-self-center border-b-2 border-pc-azul text-lg mb-4">Reasignar
    Devolución</h2>
<p class="text-pc-texto-p">Ingrese el DNI del usuario que devolverá la bicicleta por usted.</p>
<div class="text-center">
    <input id="dni" type="number" placeholder="DNI"
        class="mb-2 border-gray-400 p-2 rounded-xl border w-full shadow-sm">
    <div id="dni_error" class="bg-pc-rojo text-white rounded-md p-2 text-start text-sm hidden mb-2">
        <p>El DNI debe tener 8 dígitos.</p>
    </div>
    <button id="buscar_usuario"
        class="shadow-sm py-3 px-6 rounded-full transition duration-500 font-semibold uppercase bg-slate-50 outline outline-4 -outline-offset-4 outline-pc-azul text-pc-azul hover:bg-pc-azul hover:text-slate-50 text-center">Buscar</button>
</div>
<div class="p-4 rounded-xl bg-gray-200 mt-4">
    {{-- ¿Agregarle icono de advertencia? --}}
    <p class="text-sm text-pc-texto-p">Recuerde que sigue siendo <span class="font-semibold">el responsable
            de la bicicleta</span>. Si la
        entrega
        se realiza
        fuera de tiempo o
        se registran daños, <span class="font-semibold">la penalización recaerá en usted</span>.</p>
</div>
