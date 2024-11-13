<?php

    namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
                return $this->administrativoInicio();
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
    protected function administrativoInicio(): View
    {
        return view('administrativo.inicio');
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

        // Obtener las últimas 5 reservas del cliente
        $reservasRecientes = DB::table('reservas')
            ->join('estados_reserva', 'reservas.id_estado', '=', 'estados_reserva.id_estado')
            ->select('reservas.*', 'estados_reserva.nombre as estado')
            ->where('reservas.id_cliente_reservo', $cliente->id_usuario)
            ->orderBy('reservas.fecha_hora_retiro', 'desc')
            ->limit(5)
            ->get();

        $datos = [
            'nombre' => $usuario->nombre,
            'apellido' => $usuario->apellido,
            'saldo' => $cliente->saldo,
            'puntaje' => $cliente->puntaje,
            'reservasRecientes' => $reservasRecientes
        ];

        return view('cliente.inicio', compact('datos'));
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
