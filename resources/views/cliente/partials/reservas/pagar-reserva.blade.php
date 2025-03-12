<div class="flex flex-wrap lg:flex-nowrap gap-6 justify-center items-center h-full">
    <!-- Contenedor de Datos de Reserva -->
    <div id="contenedorDatosReserva"
        class="bg-gradient-to-br from-pc-naranja to-pc-rojo w-full lg:w-1/2 p-4 shadow-md rounded-xl flex flex-col gap-6">
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

    <!-- Contenedor de Pagar Reserva -->
    <div id="contenedorPagarReserva" class="flex flex-col gap-4 mt-5 w-full lg:w-1/3">
        <!-- Mostrar el saldo aquí -->
        <p id="idSaldo" class="text-pc-texto-p text-base border-l-4 border-l-pc-rojo pl-2">
            Saldo actual disponible: ${{ $saldo_actual }} <!-- Asegúrate de tener $saldo_actual disponible -->
        </p>

        <p class="text-pc-texto-p text-base border-l-4 border-l-pc-rojo pl-2">El monto de la seña de la reserva es de
            ${{ $reserva['monto_senia'] }}</p>
        <div class="flex gap-6 self-center">
            <form id="formularioPagarReserva" action="{{ route('reservar.pagar-reserva') }}" method="POST"
                class="row-auto">
                @csrf
                <input type="hidden" name="paso" id="paso">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <button type="button" id="mandarFormularioPagarReserva"
                    class="py-2 px-4 rounded-full font-semibold bg-slate-50 shadow-md my-8 border-4 border-pc-rojo"
                    value="4" onclick="enviarFormularioPagarReserva()">Pagar reserva</button>
            </form>
        </div>
    </div>
</div>


<div id="modalConfirmacion"
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 invisible">
    <div class="bg-white p-6 rounded-lg shadow-lg w-11/12 sm:w-1/3">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Saldo insuficiente para pagar la reserva. ¿Quiere cargar
            saldo en su cuenta?</h2>
        <div class="flex gap-4 justify-center">
            <button onclick="mostrarCargarSaldo()"
                class="shadow-md py-3 px-6 rounded-full transition duration-500 font-semibold uppercase bg-slate-50 outline outline-4 -outline-offset-4 outline-pc-azul text-pc-azul hover:bg-pc-azul hover:text-slate-50">
                Si
            </button>
            <button type="button" onclick="toggleModal('modalConfirmacion')"
                class="shadow-md py-3 px-6 rounded-full transition duration-500 font-semibold uppercase bg-slate-50 outline outline-4 -outline-offset-4 outline-pc-azul text-pc-azul hover:bg-pc-azul hover:text-slate-50">
                No
            </button>
        </div>
    </div>
</div>

<div id="contenedorSaldoCargado"
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 invisible">
    <div class="bg-white p-6 rounded-lg shadow-lg w-11/12 sm:w-1/3">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Carga realizada con éxito.</h2>
        <div class="flex gap-4 justify-center">
            <button type="button" onclick="toggleModal('contenedorSaldoCargado')"
                class="shadow-md py-3 px-6 rounded-full transition duration-500 font-semibold uppercase bg-slate-50 outline outline-4 -outline-offset-4 outline-pc-azul text-pc-azul hover:bg-pc-azul hover:text-slate-50">
                Volver
            </button>
        </div>
    </div>
</div>

<div id="overlay" class="fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-30 invisible">
    <div id="tarjeta_cargar_saldo" class="relative flex flex-col bg-white rounded-3xl shadow-xl w-[500px] max-w-[90%]">

        <!-- Botón de cerrar -->
        <button id="cerrar_tarjeta" class="absolute right-6 top-6 text-gray-400 hover:text-gray-600 transition-colors"
            onclick="ocultarBusqueda()">
            <svg xmlns="http://www.w3.org/2000/svg" height="20px" width="20px" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Contenido -->
        <div class="p-8">
            @include('cliente.partials.pasarela-de-pago')
        </div>
    </div>
</div>
