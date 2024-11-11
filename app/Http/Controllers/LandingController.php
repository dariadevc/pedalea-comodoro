<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Reserva;
use App\Models\Estacion;
use App\Models\Bicicleta;
use Illuminate\View\View;
use App\Models\Configuracion;
use App\Models\EstadoBicicleta;
use App\Models\EstadoEstacion;
use App\Models\EstadoReserva;

class LandingController extends Controller
{
    /**
     * Muestra la vista de la página landing.
     * 
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $cantidad_estaciones = Estacion::where('id_estado', EstadoEstacion::ACTIVA)->count();
        $cantidad_bicicletas = Bicicleta::where('id_estado', EstadoBicicleta::DISPONIBLE)->count();
        $cantidad_clientes = Cliente::count();
        $cantidad_reservas = Reserva::where('id_estado', EstadoReserva::FINALIZADA)->count();
        $tarifa = Configuracion::where('clave', 'tarifa')->value('valor');

        return view('invitado.landing', compact(
            'cantidad_estaciones',
            'cantidad_bicicletas',
            'cantidad_clientes',
            'cantidad_reservas',
            'tarifa'
        ));
    }
}
