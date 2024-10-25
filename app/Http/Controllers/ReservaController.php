<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ReservaController extends Controller
{
    public function mostrarVistaAlquilar(): View
    {
        return view('cliente.alquilar');
    }

    public function alquilar(Request $request)
    {
        if ($request->bicicletaDisponible) {
            
        }
    }
}
