<?php

namespace App\Http\Controllers;

use App\Models\Bicicleta;
use App\Models\Cliente;
use App\Models\Configuracion;
use App\Models\Estacion;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        $cantidad_estaciones = Estacion::where('id_estado', 1)->count();
        $cantidad_bicicletas = Bicicleta::where('id_estado', 1)->count();
        $cantidad_clientes = Cliente::count();
        $cantidad_reservas = Reserva::where('id_estado', 3)->count();
        $tarifa = Configuracion::where('clave', 'tarifa')->value('valor');

        return view('invitado.landing', compact(
            'cantidad_estaciones', 'cantidad_bicicletas', 'cantidad_clientes', 'cantidad_reservas',
            'tarifa'
            ));
    }
}
