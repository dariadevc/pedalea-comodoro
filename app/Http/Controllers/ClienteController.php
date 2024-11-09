<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{

    public function indexCargarSaldo()
    {
        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();

        if (!$cliente->estoySuspendido()) {
            return view('cliente.cargar_saldo')->render();
        } else {
            return redirect()->route('inicio')
                ->with('error', 'Su cuenta se encuentra suspendida.');
        }
    }

    public function storeCargarSaldo(Request $request)
    {
        $request->validate([
            'monto' => 'required|numeric'
        ]);

        // ACA TENDRIA QUE IR LA PASARELA DE PAGO

        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();

        if (rand(0, 1)) {
            $monto = floatval($request->monto);
            $cliente->agregarSaldo($monto);

            return redirect()->route('inicio')
                ->with('success', 'Se ha cargado satisfactoriamente su saldo.');
        } else {
            return redirect()->route('cargar-saldo.index')
                ->with('error', 'Ha ocurrido un error al procesar su pago.')
                ->withInput();
        }
    }

    public function restarPuntos()
    {
        return view('cliente.restar_puntos');
    }

    public function storeRestarPuntos(Request $request)
    {
        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();
        $cliente->actualizarPuntaje($request->puntos);
        return redirect()->route('restar-puntos')->with('success', 'Puntos restados correctamente ' . $request->puntos);
    }

    public function restablecer_multas_hechas()
    {
        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();
        $cliente->reiniciarMultasSuspensionHechasPorDia();
        return redirect()->route('restar-puntos')->with('success', 'Multas restablecidas por dia');

    }

    public function verPerfilCliente(Request $request){

        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();

        if($cliente){

            $perfil = DB::table('clientes')
            ->select('clientes.puntaje', 'clientes.fecha_nacimiento', 'usuarios.nombre as nombre', 'usuarios.apellido as apellido', 'usuarios.email as email')
            ->join('usuarios', 'clientes.id_usuario', "=", 'usuarios.id_usuario') 
            ->where('clientes.id_usuario', $cliente->id_usuario)
            ->first();

        }else{
        
            $perfil = [];
        }
        return view('cliente.perfil', compact('perfil'));
    }
}
