<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReservaController extends Controller
{
    public function mostrarVistaAlquilar(): View
    {
        return view('cliente.alquilar');
    }

    public function seEncuentraBici(Request $request)
    {
        $se_encuentra_bicicleta = $request->input('bicicletaDisponible');
        $usuario = Auth::user();
        // $cliente = $usuario->obtenerCliente();
        // $reserva = $cliente->obtenerReservaActual();

        if ($se_encuentra_bicicleta === 'Si') {
            return response()->json(['success' => true]);
        } elseif ($se_encuentra_bicicleta === 'No') {
            return response()->json(['error' => true]);
        }
    }
}
