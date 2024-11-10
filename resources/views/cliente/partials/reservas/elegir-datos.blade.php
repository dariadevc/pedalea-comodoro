
<div id="contenedorFormDatosReserva" class="flex flex-col lg:flex-row gap-6 mt-5 w-full">
    <!-- Formulario de reserva -->
    <div class="bg-gradient-to-br from-pc-naranja to-pc-rojo w-full lg:w-2/3 p-4 shadow-md rounded-xl flex flex-col gap-6">
        <form id="formularioHorarioRetiro" action="{{ route('estaciones.disponibilidad-horario-retiro') }}" method="POST"
            class="shadow-md rounded-xl flex flex-col gap-6">
            @csrf
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <input type="hidden" name="paso" id="paso">

            <div class="flex flex-col gap-2 py-2 px-4 bg-gray-50 rounded-xl shadow-sm">
                <label for="horario_retiro" class="font-semibold text-wrap text-pc-texto-h border-b-2 border-b-pc-texto-h self-start">Horario de Retiro</label>
                <input type="time" id="horario_retiro" name="horario_retiro"
                    class="bg-gray-50 border-b-2 text-pc-texto-p w-full sm:max-w-xs" onchange="traerEstacionesDisponibles()">
                <div id="error-horario-retiro" class="error-message text-black-500 text-sm border-l-4 border-l-pc-rojo pl-2 disabled"></div>
            </div>
        </form>

        <form id="formularioDatosReserva" action="{{ route('reservar.crearReserva') }}" method="POST"
            class="shadow-md rounded-xl flex flex-col gap-6">
            @csrf
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <input type="hidden" id="horario_retiro_reserva" name="horario_retiro_reserva" value="">

            <div class="flex flex-col gap-2 py-2 px-4 bg-gray-50 rounded-xl shadow-sm">
                <label for="estacion_retiro" class="font-semibold text-wrap text-pc-texto-h border-b-2 border-b-pc-texto-h self-start">Estación de Retiro</label>
                <select id="estacion_retiro" name="estacion_retiro" class="bg-gray-50 border-b-2 text-pc-texto-p" disabled></select>
                <div id="error-estacion-retiro" class="error-message text-black-500 text-sm border-l-4 border-l-pc-rojo pl-2 disabled"></div>
            </div>

            <div class="flex flex-col gap-2 py-2 px-4 bg-gray-50 rounded-xl shadow-sm">
                <label for="estacion_devolucion" class="font-semibold text-wrap text-pc-texto-h border-b-2 border-b-pc-texto-h self-start">Estación de Devolución</label>
                <select id="estacion_devolucion" name="estacion_devolucion" class="bg-gray-50 border-b-2 text-pc-texto-p" disabled></select>
                <div id="error-estacion-devolucion" class="error-message text-black-500 text-sm border-l-4 border-l-pc-rojo pl-2 disabled"></div>
            </div>

            <div class="flex flex-col gap-2 py-2 px-4 bg-gray-50 rounded-xl shadow-sm">
                <label for="tiempo_uso" class="font-semibold text-wrap text-pc-texto-h border-b-2 border-b-pc-texto-h self-start">Tiempo de uso</label>
                <select id="tiempo_uso" name="tiempo_uso" class="bg-gray-50 border-b-2 text-pc-texto-p" disabled></select>
                <div id="error-tiempo-uso" class="error-message text-black-500 text-sm border-l-4 border-l-pc-rojo pl-2 disabled"></div>
            </div>
        </form>
    </div>

    <div id="contenedorInformacion" class="flex flex-col gap-4 mt-5 w-full lg:w-1/3 justify-center">
        <div class="">
            <p id="parrafoInformacion" class="text-pc-texto-p text-base border-l-4 border-l-pc-rojo pl-2">
                Complete los siguientes datos para reservar una bicicleta
            </p>
        </div>
        <div class="flex gap-6 self-center">
            <button id="mandarFormulario" type="button" value="2"
                class="py-2 px-4 rounded-full font-semibold bg-slate-50 shadow-md my-8 border-4 border-pc-rojo"
                onclick="mandarFormularioDatosReserva()">
                Reservar una Bicicleta
            </button>
        </div>
    </div>
</div>
