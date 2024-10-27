<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReservaController extends Controller
{
    public function mostrarVistaAlquilar()
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
        $nueva_bicicleta = $estacion_retiro->getBicicletaDisponible();
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
}
