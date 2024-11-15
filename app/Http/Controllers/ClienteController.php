<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    /** 
     * Muestra la vista para r saldo o redirige si el cliente está suspendido. 
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse 
     * */
    public function indexCargarSaldo()
    {
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
     */
    public function storeCargarSaldo(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:100',
            'cardNumber' => 'required|digits_between:16,19',
            'cardName' => 'required|string|max:255',
            'expiryDate' => 'required|regex:/^\d{2}\/\d{2}$/',
            'cvv' => 'required|digits:3',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        if (rand(1, 0)) {
            /** @var \App\Models\User $usuario */
            $usuario = Auth::user();
            $cliente = $usuario->obtenerCliente();
            $cliente->agregarSaldo($request->amount, 'Carga de saldo');
            $saldo = $cliente->saldo;
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'mensaje' => "Carga realizada con éxito. Su saldo actual es de \${$saldo}",
                    'saldo' => $saldo,
                ]);
            }

            return redirect()->route('inicio')->with('success', 'Carga realizada con éxito');
        }
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'mensaje' => 'No se pudo cargar el saldo. Intente nuevamente.'
            ]);
        }

        return redirect()->back()->with('error', 'No se pudo cargar el saldo. Intente nuevamente.')->withInput();
    }

    public function verPerfilCliente(Request $request)
    {
        /** @var \App\Models\User $usuario */
        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();

        return view('cliente.perfil', compact('cliente', 'usuario'));
    }

    public function mostrarCargarSaldoModal()
    {
        $vista_html = view('cliente.cargar-saldo-modal')->render();
        return response()->json([[
            'success' => true,
            'html' => $vista_html
        ]]);
    }
}
