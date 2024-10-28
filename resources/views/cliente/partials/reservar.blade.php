@extends('layouts.cliente')

@section('titulo', 'Pedalea Comodoro | Reservar')

@section('nombre_seccion', 'Reservar')

@section('contenido')
    <div class="">
        <p class="text-pc-texto-p text-sm border-l-4 border-l-pc-rojo pl-2">
            Complete los siguientes datos para reservar una bicicleta
        </p>
    </div>
    {{-- TODO: Tenemos que desactivar todas las opciones (menos la primera) hasta que eija lel horario de retiro, y habilitarlas una vez lo haga --}}
    <form action="" class="text-center">
        <div class="bg-gradient-to-br from-pc-naranja to-pc-rojo w-full p-4 shadow-md rounded-xl flex flex-col gap-6">
            <div class="flex flex-col gap-2 py-2 px-4 bg-gray-50 rounded-xl shadow-sm">
                <label for="horario_retiro"
                    class="font-semibold text-wrap text-pc-texto-h border-b-2 border-b-pc-texto-h self-start">Horario de
                    Retiro</label>
                <input type="time" name="horario_retiro" id="" class="bg-gray-50 border-b-2 text-pc-texto-p">
            </div>
            <div class="flex flex-col gap-2 py-2 px-4 bg-gray-50 rounded-xl shadow-sm">
                <label for="estacion_retiro"
                    class="font-semibold text-wrap text-pc-texto-h border-b-2 border-b-pc-texto-h self-start">Estación de
                    Retiro</label>
                {{-- Select deshabilitado, ya que todavía no eligió el horario de retiro --}}
                <select name="estacion_retiro" class="bg-gray-50 border-b-2 text-pc-texto-p" disabled>
                    <option value="" disabled selected>Seleccione una opción</option>
                    <option value="opt1">Av. Tehuelche</option>
                    <option value="opt2">Opción 2</option>
                    <option value="opt3">Opción 3</option>
                </select>
            </div>
            <div class="flex flex-col gap-2 py-2 px-4 bg-gray-50 rounded-xl shadow-sm">
                <label for="estacion_devolucion"
                    class="font-semibold text-wrap text-pc-texto-h border-b-2 border-b-pc-texto-h self-start">Estación de
                    Devolución</label>
                {{-- Select deshabilitado, ya que todavía no eligió el horario de retiro --}}
                <select name="estacion_devolucion" class="bg-gray-50 border-b-2 text-pc-texto-p" disabled>
                    <option value="" disabled selected>Seleccione una opción</option>
                    <option value="opt2">Av. Alsina</option>
                    <option value="opt3">Opción 3</option>
                </select>
            </div>
            <div class="flex flex-col gap-2 py-2 px-4 bg-gray-50 rounded-xl shadow-sm">
                <label for="tiempo_uso"
                    class="font-semibold text-wrap text-pc-texto-h border-b-2 border-b-pc-texto-h self-start">Tiempo de
                    uso</label>
                {{-- Select deshabilitado, ya que todavía no eligió el horario de retiro --}}
                <select name="tiempo_uso" class="bg-gray-50 border-b-2 text-pc-texto-p" disabled>
                    <option value="" disabled selected>Seleccione una opción</option>
                    <option value="opt1">1h</option>
                    <option value="opt2">2hs</option>
                    <option value="opt3">3hs</option>
                    <option value="opt4">4hs</option>
                    <option value="opt5">5hs</option>
                    <option value="opt6">6hs</option>
                </select>
            </div>
        </div>

        <button class="py-2 px-4 rounded-full font-semibold bg-slate-50 shadow-md my-8 border-4 border-pc-rojo">
            Reservar una Bicicleta
        </button>

        {{-- TODO: Faltaría una vista que le muestre todos los datos junto con el valor de la seña y que tenga un botón que diga "Pagar Reserva" o "Pagar Seña" --}}
        {{-- TODO: Al apretar el botón de pagar debería saltar un cartel que tenga un mensaje informando que la reserva se realizó con éxito y un botón que te manda al inicio --}}

    </form>
@endsection
