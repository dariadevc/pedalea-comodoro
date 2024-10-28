<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

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
        $reserva_actual = $usuario->obtenerCliente()->obtenerReservaActivaModificada();

        $estacion_retiro = $reserva_actual->estacionRetiro;
        $nueva_bicicleta = $estacion_retiro->getBicicletaDisponibleAhora();
        if ($nueva_bicicleta) {
            $reserva_actual->asignarNuevaBicicleta($nueva_bicicleta);
            return response()->json(['success' => true, 'mensaje' => 'Se le asigno una nueva bicicleta de la estación']);
        }
        /**
         * FALTA REALIZAR LA LOGICA DE QUE SI NO HAY BICICLETAS DISPONIBLES
         * PREGUNTAR SI QUIERE QUE SE LE MODIFIQUE
         */
        return response()->json(['success' => false, 'mensaje' => 'No hay bicicletas disponibles en esta estación.']);
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

    // -------------
    // RESERVAR
    // -------------


    public function indexReserva()
    {
        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();

        if (!($cliente->tengoUnaReserva())) {
            return view('cliente.reservar');
        }

        return redirect()->back()->with('error', 'Hay una reserva actualmente activa, no puedes reservar.');
    }

    public function crearReserva(Request $request)
    {
        $validador = Validator::make($request->all(), [
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
}
