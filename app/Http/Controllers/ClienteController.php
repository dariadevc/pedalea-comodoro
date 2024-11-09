<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class ClienteController extends Controller
{
    /** 
     * Muestra la vista para cargar saldo o redirige si el cliente está suspendido. 
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse 
     * */
    public function indexCargarSaldo()
    {
        dump('Cuando este la vista de la pasarela de pago y termine de pagar hay que redirigir a esta vista, si es nulo, redirige al inicio');
        dump(session('url_actual'));
        /** @var \App\Models\User $usuario */
        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();

        if (!$cliente->estoySuspendido()) {
            return view('cliente.cargar_saldo')->render();
        } else {
            return redirect()->route('inicio')
                ->with('error', 'Su cuenta se encuentra suspendida.');
        }
    }

    /**
     * Actualiza el saldo del cliente en la base de datos.
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeCargarSaldo(Request $request): RedirectResponse
    {
        $request->validate([
            'monto' => 'required|numeric'
        ]);

        /** @var \App\Models\User $usuario */
        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();

        if (rand(0, 1)) {
            $monto = floatval($request->monto);
            $motivo = 'Carga de saldo';
            $cliente->agregarSaldo($monto, $motivo);

            return redirect()->route('inicio')
                ->with('success', 'Se ha cargado satisfactoriamente su saldo.');
        } else {
            return redirect()->route('cargar-saldo.index')
                ->with('error', 'Ha ocurrido un error al procesar su pago.')
                ->withInput();
        }
    }
}
