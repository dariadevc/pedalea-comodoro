<?php

namespace App\Http\Controllers;


use App\Models\Estacion;
use App\Models\Bicicleta;
use App\Models\Reserva;
use App\Models\Cliente;
use App\Models\User;
use App\Rules\HorarioRetiro;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;


use function Pest\Laravel\json;

class ReservaController extends Controller
{

    // -------------
    // ALQUILAR
    // -------------

    public function indexAlquilar()
    {
        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();
        $reserva = $cliente->obtenerReservaActivaModificada();

        if ($reserva) {
            $reserva = $reserva->formatearDatosActiva();
            return view('cliente.alquilar', compact('reserva'));
        }

        return redirect()->back()->with('error', 'No hay ninguna reserva activa.');
    }

    public function bicicletaDisponible(Request $request)
    {
        $usuario = Auth::user();
        $reserva_actual = $usuario->obtenerCliente()->obtenerReservaActivaModificada();
        $bicicleta = $reserva_actual->bicicleta;

        if ($bicicleta->estoyEnUnaReserva()) {
            $reserva_alquilada = $bicicleta->getReservaActual();
            $reserva_alquilada->cerrarAlquiler();
        }

        return response()->json(['success' => true]);
    }

    public function bicicletaNoDisponible(Request $request)
    {
        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();
        // Verificación de existencia de reserva
        $tieneReserva = $cliente->tengoUnaReserva();

        if (!$tieneReserva) {
            return response()->json(['success' => false, 'mensaje' => 'El cliente no tiene ninguna reserva activa.']);
        }
        $reserva_actual = $cliente->obtenerReservaActivaModificada();

        if (!$reserva_actual || !isset($reserva_actual->id_reserva)) {

            return response()->json(['success' => false, 'mensaje' => 'Reserva no encontrada.']);
        }

        $estacion_retiro = $reserva_actual->estacionRetiro;
        $nueva_bicicleta = $estacion_retiro->getBicicletaDisponibleAhora();
        if ($nueva_bicicleta) {
            $reserva_actual->asignarNuevaBicicleta($nueva_bicicleta);
            return response()->json(['success' => true, 'mensaje' => 'Se le asigno una nueva bicicleta de la estación']);
        }

        $estacion_retiro = $reserva_actual->estacionRetiro;
        $bicicleta_asignada = $reserva_actual->bicicleta;

        if (is_null($bicicleta_asignada->id_estacion_actual && $reserva_actual->id_estacion_retiro != $bicicleta_asignada->id_estacion_actual)) {
            session(['id_reserva' => $reserva_actual->id_reserva]);
            return response()->json(['success' => false, 'mensaje' => 'La bicicleta no está disponible en la estación.', 'redirectUrl' => route('reservas.modificar')]);
        }
        $nueva_bicicleta = $estacion_retiro->bicicletas()->whereNull('id_estacion_actual')->first();

        if ($nueva_bicicleta) {
            $reserva_actual->asignarNuevaBicicleta($nueva_bicicleta);
            session(['id_reserva' => $reserva_actual->id_reserva]);
            return response()->json(['success' => true, 'mensaje' => 'Se le asignó una nueva bicicleta de la estación']);
        }

        session(['id_reserva' => $reserva_actual->id_reserva]);
        return response()->json(['success' => false, 'mensaje' => 'No hay bicicletas disponibles en esta estación.', 'redirectUrl' => route('reservas.modificar')]);
    }

    public function pagarAlquiler(Request $request)
    {
        $inputPagar = $request->input('pagar');

        if (!($inputPagar === '')) {
            $usuario = Auth::user();
            $cliente = $usuario->obtenerCliente();
            $reserva = $cliente->obtenerReservaActivaModificada();

            if ($reserva->alquilar($cliente, $usuario)) {
                return response()->json([
                    'success' => true,
                    'mensaje' => 'Alquiler realizado correctamente.',
                    'redirect' => route('inicio')
                ]);
            } else {
                return response()->json(['success' => false, 'mensaje' => 'No se pudo realizar el alquiler.']);
            }
        }
    }

    public function indexAlquilerActual()
    {
        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();


        if ($cliente->estoySuspendido()) {
            return redirect()->route('inicio')
                ->with('error', 'Su cuenta se encuentra suspendida.');
        }

        $reserva = $cliente->obtenerReservaAlquiladaReasignada();
        if (!$reserva) {
            return redirect()->route('inicio')
            ->with('error', 'No tiene actualmente un alquiler.');
        }
        
        $estado_reserva = $reserva->getEstadoReserva();

        //? Es correcto que obtenga el id del cliente que va a devolver?
        $id_cliente_devuelve = $reserva->getClienteDevuelve();
        $usuario_devuelve = User::obtenerUsuarioPorId($id_cliente_devuelve); //Crea una instancia del usuario para poder mostrar su nombre y apellido en el alquiler actual

        if ($reserva && $reserva->estoyAlquilada()) {
            $reserva = $reserva->formatearDatosActiva();
            return view('cliente.alquiler_actual', compact('reserva', 'estado_reserva', 'usuario_devuelve'));
        }

        return redirect()->back()->with('error', 'No hay ninguna reserva activa.');
    }

    public function buscarUsuario(Request $request)
    {
        // TODO: Manejar excepciones
        //El cliente no puede asignarse la devolución a sí mismo.
        //El DNI tiene que estar en un rango numérico.
        //
        //Valida el DNI
        $request->validate([
            'dni' => 'required|numeric|between:20000000,99999999|digits:8',
        ]);



        $usuario = Auth::user();
        $dni = $request->dni;

        //Excepción: El usuario no se puede reasignar la devolución a sí mismo
        if ($usuario->dni == $dni) {
            return response()->json([
                'status' => 'error',
                'errorView' => view('cliente.partials.error_autoasignacion_reasignar')->render(),
            ]);
        }
        $cliente = $usuario->obtenerCliente();
        $reserva = $cliente->obtenerReservaAlquiladaReasignada();


        // Buscar el cliente por DNI
        $usuario_devuelve = User::obtenerUsuarioPorDni($request->dni);

        if (!$usuario_devuelve) {
            return response()->json([
                'status' => 'error',
                'errorView' => view('cliente.partials.error_reasignar')->render(),
            ]);
        }

        // Comprueba que usuario exista y que sea un cliente
        $cliente_devuelve = $usuario_devuelve->obtenerCliente();
        if (!$cliente_devuelve) {
            return response()->json([
                'status' => 'error',
                'errorView' => view('cliente.partials.error_reasignar')->render(),
            ]);
        }
        if (!$cliente_devuelve->estoySuspendido()) {
            $reserva->reasignarDevolucion($cliente_devuelve);

            // Devuelve el JSON que le paso a la vista a través de ajax para modificar los contenedores #usuario_devuelve y #tarjeta_reasignar
            return response()->json([
                'status' => 'success',
                'successView' => view('cliente.partials.exito_reasignar')->render(),
            ]);
        }
        return response()->json([
            'status' => 'error',
            'errorView' => view('cliente.partials.usuario_suspendido_reasignar')->render(),
        ]);
    }

    // -------------
    // RESERVAR
    // -------------


    public function indexReserva()
    {
        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();

        // if (!($cliente->tengoUnaReserva())) {
        //     return view('cliente.reservar');
        // }

        if (!($cliente->tengoUnaReserva())) {
            return view('cliente.reservar')->render();
        } else {
            return redirect()->route('inicio')
                ->with('error', 'Su cuenta se encuentra suspendida.');
        }

        return redirect()->back()->with('error', 'Hay una reserva actualmente activa, no puedes reservar.');
    }

    public function crearReserva(Request $request)
    {
        $validador = Validator::make($request->all(), [
            'horario_retiro_reserva' => ['required', new HorarioRetiro],
            'estacion_retiro' => 'required|integer|exists:estaciones,id_estacion',
            'estacion_devolucion' => 'required|integer|exists:estaciones,id_estacion',
            'tiempo_uso' => 'required|integer|min:1|max:6',
        ], [
            'estacion_retiro.required' => 'La estación de retiro es obligatoria.',
            'estacion_retiro.integer' => 'La estación de retiro debe ser un número.',
            'estacion_retiro.exists' => 'La estación de retiro seleccionada no existe.',
            'estacion_devolucion.required' => 'La estación de devolución es obligatoria.',
            'estacion_devolucion.integer' => 'La estación de devolución debe ser un número.',
            'estacion_devolucion.exists' => 'La estación de devolución seleccionada no existe.',
            'tiempo_uso.required' => 'El tiempo de uso es obligatorio.',
            'tiempo_uso.integer' => 'El tiempo de uso debe ser un número.',
            'tiempo_uso.min' => 'El tiempo de uso mínimo es 1 hora.',
            'tiempo_uso.max' => 'El tiempo de uso máximo es 6 horas.',
        ]);

        if ($validador->fails()) {
            // Si hay errores, devolvemos los mensajes como JSON con el código de estado 422
            return response()->json(['errors' => $validador->errors()], 422);
        }
        $reserva_pendiente = Reserva::crearReserva(
            $request->input('horario_retiro_reserva'),
            $request->input('tiempo_uso'),
            $request->input('estacion_devolucion'),
            $request->input('estacion_retiro'),
            Auth::user()->id_usuario,
        );
        session(['reserva_pendiente' => $reserva_pendiente]);

        return response()->json([
            'success' => true,
        ]);
    }


    public function reservarDatosCorrectos(Request $request)
    {
        return response()->json(['success' => true]);
    }

    public function reservarDatosIncorrectos(Request $request)
    {
        return response()->json([
            'success' => true,
            'mensaje' => 'Datos incorrectos.',
            'redirect' => route('reservar.index')
        ]);
    }

    public function reservarPasos(Request $request)
    {
        switch ($request->input('paso')) {
            case '1':
                return view('cliente.reservas.elegir-datos')->render();

            case '2':
                $reserva_pendiente = session('reserva_pendiente');
                $reserva_formateada = $reserva_pendiente->formatearDatosParaReservar();
                return view('cliente.reservas.confirmar', ['reserva' => $reserva_formateada])->render();
            case '3':
                $reserva_pendiente = session('reserva_pendiente');
                $reserva_formateada = $reserva_pendiente->formatearDatosParaReservar();
                return view('cliente.reservas.pagar-reserva', ['reserva' => $reserva_formateada])->render();
        }
    }

    public function pagarReserva(Request $request)
    {
        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();
        $reserva = session('reserva_pendiente');

        if ($reserva->reservar($cliente, $usuario)) {
            session()->forget('reserva_pendiente');

            return response()->json([
                'success' => true,
                'mensaje' => 'Reserva realizada correctamente.',
                'redirect' => route('inicio')
            ]);
        } else {
            return response()->json(['success' => false, 'mensaje' => 'No se pudo realizar la reserva.']);
        }
    }

    public function indexReservaActual()
    {
        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();

        if ($cliente->estoySuspendido()) {
            return redirect()->route('inicio')
                ->with('error', 'Su cuenta se encuentra suspendida.');
        }

        $reserva = $cliente->obtenerReservaActivaModificada();

        if ($reserva && $reserva->estoyReservada()) {
            $reserva = $reserva->formatearDatosActiva();
            return view('cliente.reserva_actual', compact('reserva'));
        }

        return redirect()->back()->with('error', 'No hay ninguna reserva activa.');
    }

    //////////////////
    //Modificar Reserva
    //////////////////
    public function modificarReservaC(Request $request)
    {
        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();
        $reserva_id = session('id_reserva');

        if (!$reserva_id) {
            return response()->json(['success' => false, 'mensaje' => 'No se ha encontrado la reserva en la sesión.']);
        }

        $reserva = Reserva::find($reserva_id);

        if (!$reserva) {
            return response()->json(['success' => false, 'mensaje' => 'Reserva no encontrada.']);
        }

        $nuevaEstacionYBicicleta = Reserva::obtenerNuevaEstacionYBicicleta($reserva->id_estacion_retiro);

        if (!$nuevaEstacionYBicicleta) {
            return response()->json(['success' => false, 'mensaje' => 'No hay bicicletas disponibles en las estaciones cercanas.']);
        }
        $nuevaEstacion = Estacion::find($nuevaEstacionYBicicleta['nuevaEstacionId']);
        $nuevaBicicleta = $nuevaEstacionYBicicleta['bicicleta'];
        $nuevoHoraRetiro = $reserva->fecha_hora_retiro->addMinutes(15);

        return view('cliente.ModificarReserva', compact('reserva', 'nuevaEstacion', 'nuevaBicicleta', 'nuevoHoraRetiro'));
    }

    public function confirmarModificacionReserva(Request $request)
    {
        $request->validate([
            'id_reserva' => 'required|integer',
            'id_bicicleta' => 'required|integer',
            'id_estacion_retiro' => 'required|integer',
            'nuevoHorarioRetiro' => 'required|date',
        ]);

        $reserva = Reserva::find($request->id_reserva);

        if (!$reserva) {
            return response()->json(['success' => false, 'mensaje' => 'Reserva no encontrada.']);
        }
        //Actuzalimos los datos y los guardamos en la BD
        $reserva->id_bicicleta = $request->id_bicicleta;
        $reserva->id_estacion_retiro = $request->id_estacion_retiro;
        $reserva->id_estado = 5;
        $reserva->fecha_hora_retiro = $request->nuevoHorarioRetiro;
        $reserva->save();

        return response()->json(['success' => true, 'mensaje' => 'Reserva modificada correctamente.']);
    }

    public function rechazarModificacion(Request $request, Reserva $reserva)
    {
        $request->validate([
            'id_reserva' => 'required|integer|exists:reservas,id_reserva',
        ]);

        $idReserva = $request->input('id_reserva');
        $reserva = Reserva::find($idReserva);

        if (!$reserva) {
            return response()->json(['success' => false, 'mensaje' => 'Reserva no encontrada.']);
        }

        if (is_null($reserva->senia)) {
            return response()->json(['success' => false, 'mensaje' => 'El campo senia es null.']);
        }

        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();

        if (!$cliente) {
            return response()->json(['success' => false, 'mensaje' => 'Cliente no encontrado.']);
        }


        $saldoAnterior = $cliente->saldo;
        $senia = $reserva->senia;
        $cliente->saldo += $senia;

        if ($cliente->save()) {
            Log::info('Saldo devuelto al cliente', ['saldo' => $cliente->saldo]);
        } else {
            Log::error('Error al guardar el saldo del cliente');
        }

        $reserva->id_estado = 4;

        if ($reserva->save()) {
            Log::info('Reserva cancelada con éxito');
        } else {
            Log::error('Error al guardar el estado de la reserva');
        }

        return response()->json(['success' => true, 'mensaje' => 'Reserva cancelada y saldo devuelto exitosamente.']);
    }
}
