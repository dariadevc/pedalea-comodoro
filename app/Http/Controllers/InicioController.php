<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InicioController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();

        // Verificar el rol del usuario
        if ($usuario->hasRole('administrativo')) {
            return view('administrativo.inicio');
        } elseif ($usuario->hasRole('cliente')) {
            $cliente = $usuario->obtenerCliente();
            $datos = [
                'nombre' => $usuario->nombre,
                'apellido' => $usuario->apellido,
                'saldo' => $cliente->saldo,
                'puntaje' => $cliente->puntaje,
            ];
            return view('cliente.inicio', compact('datos'));
        } elseif ($usuario->hasRole('inspector')) {
            return view('inspector.inicio');
        }

        return redirect()->route('landing');
    }
}
