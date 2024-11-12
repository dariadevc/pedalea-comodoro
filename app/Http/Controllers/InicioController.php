<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Configuracion;
use App\Models\Cliente;
use App\Models\Reserva;
use Illuminate\Support\Facades\Auth;

class InicioController extends Controller
{
    /**
     * Muestra el inicio correspondiente de cada rol.
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        /** @var \App\Models\User $usuario */
        $usuario = Auth::user();

        switch (true) {
            case $usuario->hasRole('cliente'):
                return $this->clienteInicio($usuario);
            case $usuario->hasRole('administrativo'):
                return $this->administrativoInicio($usuario);
            case $usuario->hasRole('inspector'):
                return $this->inspectorInicio();
            default:
                return redirect()->route('landing');
        }
    }

    /**
     * Muestra la vista del inicio para el rol administrativo.
     * 
     * @return \Illuminate\View\View
     */
    protected function administrativoInicio($usuario): View
    {
        $admin = $usuario->obtenerCliente();
        $datos = [
            'nombre' => $usuario->nombre,
            'apellido' => $usuario->apellido,
        ];
        $tarifa = Configuracion::where('clave', 'tarifa')->value('valor');
        return view('administrativo.inicio', compact('datos', 'tarifa'));
    }

    /**
     * Muestra la vista del inicio para el rol cliente.
     * 
     * @param \App\Models\User $usuario
     * @return \Illuminate\View\View
     */
    protected function clienteInicio($usuario): View
    {
        $cliente = $usuario->obtenerCliente();
        $datos = [
            'nombre' => $usuario->nombre,
            'apellido' => $usuario->apellido,
            'saldo' => $cliente->saldo,
            'puntaje' => $cliente->puntaje,
        ];
        $reserva = $cliente->obtenerUltimaReserva();
        $estado = $reserva->getNombreEstadoReserva();
        $reserva = $reserva->formatearDatosActiva();
        return view('cliente.inicio', compact('datos', 'estado', 'reserva'));
    }

    /**
     * Muestra la vista del inicio para el rol inspector.
     * 
     * @return \Illuminate\View\View
     */
    protected function inspectorInicio(): View
    {
        return view('inspector.inicio');
    }
}
