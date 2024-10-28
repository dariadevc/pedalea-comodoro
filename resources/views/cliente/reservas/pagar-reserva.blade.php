<div id="contenedorDatosReserva"
    class="bg-gradient-to-br from-pc-naranja to-pc-rojo w-full p-4 shadow-md rounded-xl flex flex-col gap-6">
    <div class="flex flex-col gap-2 py-2 px-4 bg-gray-50 rounded-xl shadow-sm">
        <label class="font-semibold text-wrap text-pc-texto-h border-b-2 border-b-pc-texto-h self-start">Estación de
            retiro</label>
        <p class="bg-gray-100 border-b-2 text-pc-texto-p p-2">{{ $reserva['estacion_retiro_nombre'] }}</p>
    </div>


    <div class="flex flex-col gap-2 py-2 px-4 bg-gray-50 rounded-xl shadow-sm">
        <label class="font-semibold text-wrap text-pc-texto-h border-b-2 border-b-pc-texto-h self-start">Estación de
            devolución</label>
        <p class="bg-gray-100 border-b-2 text-pc-texto-p p-2">{{ $reserva['estacion_devolucion_nombre'] }}</p>
    </div>

    <div class="flex flex-col gap-2 py-2 px-4 bg-gray-50 rounded-xl shadow-sm">
        <label class="font-semibold text-wrap text-pc-texto-h border-b-2 border-b-pc-texto-h self-start">Horario de
            retiro</label>
        <p class="bg-gray-100 border-b-2 text-pc-texto-p p-2">{{ $reserva['horario_retiro'] }}</p>
    </div>

    <div class="flex flex-col gap-2 py-2 px-4 bg-gray-50 rounded-xl shadow-sm">
        <label class="font-semibold text-wrap text-pc-texto-h border-b-2 border-b-pc-texto-h self-start">Tiempo de
            uso</label>
        <p class="bg-gray-100 border-b-2 text-pc-texto-p p-2">{{ $reserva['tiempo_uso'] }} horas</p>
    </div>

    <div class="flex flex-col gap-2 py-2 px-4 bg-gray-50 rounded-xl shadow-sm">
        <label class="font-semibold text-wrap text-pc-texto-h border-b-2 border-b-pc-texto-h self-start">Monto total de
            la reserva</label>
        <p class="bg-gray-100 border-b-2 text-pc-texto-p p-2">${{ $reserva['monto_total'] }}</p>
    </div>

    <div class="flex flex-col gap-2 py-2 px-4 bg-gray-50 rounded-xl shadow-sm">
        <label class="font-semibold text-wrap text-pc-texto-h border-b-2 border-b-pc-texto-h self-start">Monto de la
            seña a pagar</label>
        <p class="bg-gray-100 border-b-2 text-pc-texto-p p-2">${{ $reserva['monto_senia'] }}</p>
    </div>
</div>

<div id="contenedorPagarReserva" class="flex flex-col gap-4 mt-5">
    <p class="text-pc-texto-p text-sm border-l-4 border-l-pc-rojo pl-2">El monto de la seña de la reserva es de ${{ $reserva['monto_senia'] }}</p>
    <div class="flex gap-6 self-center">
        <form id="formularioPagarReserva" action="{{ route('reservar.pagar-reserva') }}" method="POST"
            class="row-auto">
            @csrf
            <input type="hidden" name="paso" id="paso">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <button type="button" id="mandarFormularioPagarReserva"
                class="py-2 px-4 rounded-full font-semibold bg-slate-50 shadow-md my-8 border-4 border-pc-rojo" value="4"
                onclick="enviarFormularioPagarReserva()">Pagar reserva</button>
        </form>

    </div>
</div>