<div class="">
    <p id="parrafoInformacion" class="text-pc-texto-p text-sm border-l-4 border-l-pc-rojo pl-2">
        Complete los siguientes datos para reservar una bicicleta
    </p>
</div>
{{-- TODO: Tenemos que desactivar todas las opciones (menos la primera) hasta que eija lel horario de retiro, y habilitarlas una vez lo haga --}}

<div id="contenedorFormDatosReserva"
    class="bg-gradient-to-br from-pc-naranja to-pc-rojo w-full p-4 shadow-md rounded-xl flex flex-col gap-6">
    <form id="formularioHorarioRetiro" action="{{ route('estaciones.disponibilidad-horario-retiro') }}" method="POST"
        class="flex flex-col gap-2 py-2 px-4 bg-gray-50 rounded-xl shadow-sm">
        @csrf
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <input type="hidden" name="paso" id="paso">
        <label for="horario_retiro"
            class="font-semibold text-wrap text-pc-texto-h border-b-2 border-b-pc-texto-h self-start">Horario de
            Retiro</label>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <input type="time" id="horario_retiro" name="horario_retiro"
                class="bg-gray-50 border-b-2 text-pc-texto-p w-full sm:max-w-xs" onchange="traerEstacionesDisponibles()">
            <p id="errorHorarioRetiro" class="text-black-500 text-sm border-l-4 border-l-pc-rojo pl-2 disabled"></p>
        </div>
    </form>

    <form id="formularioDatosReserva" action="{{ route('reservar.crearReserva') }}" method="POST"
        class="shadow-md rounded-xl flex flex-col gap-6">
        @csrf
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <input type="hidden" id="horario_retiro_reserva" name="horario_retiro_reserva" value="">

        <div class="flex flex-col gap-2 py-2 px-4 bg-gray-50 rounded-xl shadow-sm">
            <label for="estacion_retiro"
                class="font-semibold text-wrap text-pc-texto-h border-b-2 border-b-pc-texto-h self-start">Estación de
                Retiro</label>
            <select id="estacion_retiro" name="estacion_retiro" class="bg-gray-50 border-b-2 text-pc-texto-p"
                disabled></select>
            <div id="error-estacion-retiro"
                class="error-message text-black-500 text-sm border-l-4 border-l-pc-rojo pl-2 disabled"></div>
        </div>

        <div class="flex flex-col gap-2 py-2 px-4 bg-gray-50 rounded-xl shadow-sm">
            <label for="estacion_devolucion"
                class="font-semibold text-wrap text-pc-texto-h border-b-2 border-b-pc-texto-h self-start">Estación de
                Devolución</label>
            <select id="estacion_devolucion" name="estacion_devolucion" class="bg-gray-50 border-b-2 text-pc-texto-p"
                disabled></select>
            <div id="error-estacion-devolucion"
                class="error-message text-black-500 text-sm border-l-4 border-l-pc-rojo pl-2 disabled"></div>
        </div>

        <div class="flex flex-col gap-2 py-2 px-4 bg-gray-50 rounded-xl shadow-sm">
            <label for="tiempo_uso"
                class="font-semibold text-wrap text-pc-texto-h border-b-2 border-b-pc-texto-h self-start">Tiempo de
                uso</label>
            <select id="tiempo_uso" name="tiempo_uso" class="bg-gray-50 border-b-2 text-pc-texto-p" disabled>
                <option value="" selected>Seleccione una opción</option>
                <option value="1">1h</option>
                <option value="2">2hs</option>
                <option value="3">3hs</option>
                <option value="4">4hs</option>
                <option value="5">5hs</option>
                <option value="6">6hs</option>
            </select>
            <div id="error-tiempo-uso"
                class="error-message text-black-500 text-sm border-l-4 border-l-pc-rojo pl-2 disabled"></div>
        </div>
    </form>

</div>

<button id="mandarFormulario" type="button" value="2"
    class="py-2 px-4 rounded-full font-semibold bg-slate-50 shadow-md my-8 border-4 border-pc-rojo" onclick="mandarFormularioDatosReserva()">
    Reservar una Bicicleta
</button>
