<div id="contenedorReserva" class="flex flex-col lg:flex-row gap-6 mt-5 w-full">
    <div class="">
        <p id="parrafoInformacion" class="text-pc-texto-h text-base font-bold border-l-4 border-l-pc-rojo pl-2">
            Datos de la reserva
        </p>

    </div>
    <div id="contenedorDatosReserva"
        class="bg-gradient-to-br from-pc-naranja to-pc-rojo w-full lg:w-2/3 p-4 shadow-md rounded-xl flex flex-col gap-6">
        <!-- Información de la reserva -->

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
            <label class="font-semibold text-wrap text-pc-texto-h border-b-2 border-b-pc-texto-h self-start">Monto total
                de
                la reserva</label>
            <p class="bg-gray-100 border-b-2 text-pc-texto-p p-2">${{ $reserva['monto_total'] }}</p>
        </div>

        <div class="flex flex-col gap-2 py-2 px-4 bg-gray-50 rounded-xl shadow-sm">
            <label class="font-semibold text-wrap text-pc-texto-h border-b-2 border-b-pc-texto-h self-start">Monto de la
                seña a pagar</label>
            <p class="bg-gray-100 border-b-2 text-pc-texto-p p-2">${{ $reserva['monto_senia'] }}</p>
        </div>
    </div>

    <div class="flex flex-col lg:w-1/3 gap-4 justify-center">
        <p class="text-pc-texto-p text-base border-l-4 border-l-pc-rojo pl-2">¿Los datos de la reserva son correctos?
        </p>
        <div class="flex gap-6 self-center">
            <form id="formularioDatosCorrectos" action="{{ route('reservar.datos-correctos') }}" method="POST"
                class="row-auto">
                @csrf
                <input type="hidden" name="paso" id="paso">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <button type="button" id="mandarFormularioDatosCorrectos"
                    class="py-2 px-4 rounded-full font-semibold bg-slate-50 shadow-md my-8 border-4 border-pc-rojo"
                    value="3" onclick="enviarFormularioDatosCorrectos()">Si</button>
            </form>

            <form id="formularioDatosIncorrectos" action="{{ route('reservar.datos-incorrectos') }}" method="POST"
                class="row-auto">
                @csrf
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <button type="button" id="mandarFormularioDatosIncorrectos"
                    class="py-2 px-4 rounded-full font-semibold bg-slate-50 shadow-md my-8 border-4 border-pc-rojo"
                    onclick="enviarFormularioDatosIncorrectos()">No</button>
            </form>
        </div>
    </div>
</div>
