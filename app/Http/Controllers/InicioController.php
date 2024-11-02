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
                $cliente = $usuario->obtenerCliente(); // Esto devuelve la instancia de Cliente asociada

                // Verificar si el cliente existe antes de llamar al método
                $tieneReserva = $cliente ? $cliente->tieneReserva( $usuario->id_usuario) : false;
        
                return view('cliente.inicio',compact('tieneReserva'));
            } elseif ($usuario->hasRole('inspector')) {
                return view('inspector.inicio');
            }

            return redirect()->route('landing');
        }
    }
