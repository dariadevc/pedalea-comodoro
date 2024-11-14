{{-- CONTENEDOR PRINCIPAL PARA CENTRAR TODO --}}
<div class="flex flex-col gap-4 w-full">
    {{-- CONTENEDOR DE TITULO Y DATOS --}}
    <div class="w-full">
        <div class="flex flex-col gap-4">
            <p class="text-pc-texto-p text-base border-l-4 border-l-pc-rojo pl-2">Datos de la nueva reserva</p>
            <div
                class="bg-gradient-to-br from-pc-naranja to-pc-rojo p-4 shadow-md rounded-xl flex flex-col gap-6 w-full">
                <div class="rounded-xl bg-gray-50 p-4 shadow-md flex flex-col gap-3">
                    <div class="flex flex-col gap-1">
                        <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-rojo self-start">Nueva
                            Estación de Retiro</h3>
                        <p class="pl-4 text-lg">{{ $nuevaEstacion->nombre }}</p>
                    </div>
                    <div class="flex flex-col gap-1">
                        <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-rojo self-start">Nueva
                            Hora de Retiro</h3>
                        <p class="pl-4 text-lg">{{ $nuevoHoraRetiro }}</p>
                    </div>
                    <div class="flex flex-col gap-1">
                        <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-rojo self-start">Nueva
                            Hora de Devolución</h3>
                        <p class="pl-4 text-lg">{{ $nuevoHoraDevolucion }}</p>
                    </div>
                    <div class="flex flex-col gap-1">
                        <h3 class="font-semibold text-sm text-pc-texto-h border-b-2 border-pc-rojo self-start">Nueva
                            Bicicleta Asignada</h3>
                        <p class="pl-4 text-lg">{{ $nuevaBicicleta->patente }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BOTONES DE MODIFICAR O RECHAZAR --}}
    <div class="flex gap-4 mt-4 justify-center">
        <form method="POST" action="{{ route('reservar.confirmarModificacion') }}" class="row-auto">
            @csrf
            <input type="hidden" name="id_reserva" value="{{ $reserva->id_reserva }}">
            <input type="hidden" name="id_estacion_retiro" value="{{ $nuevaEstacion->id_estacion }}">
            <input type="hidden" name="id_bicicleta" value="{{ $nuevaBicicleta->id_bicicleta }}">
            <input type="hidden" name="nuevoHorarioRetiro" value="{{ $nuevoHoraRetiro }}">
            <input type="hidden" name="nuevoHorarioDevolucion" value="{{ $nuevoHoraDevolucion }}">
            <button type="submit"
                class="py-2 px-4 rounded-full font-semibold bg-slate-50 shadow-md border-4 border-pc-azul hover:bg-pc-azul hover:text-white cursor-pointer">
                Modificar Reserva
            </button>
        </form>
        <form method="POST" action="{{ route('reservas.rechazarModificacion') }}" class="row-auto">
            @csrf
            <input type="hidden" name="id_reserva" value="{{ $reserva->id_reserva }}">
            <button type="submit"
                class="py-2 px-4 rounded-full font-semibold bg-slate-50 shadow-md border-4 border-pc-rojo hover:bg-pc-rojo hover:text-white cursor-pointer">
                Rechazar Reserva
            </button>
        </form>
    </div>
</div>
