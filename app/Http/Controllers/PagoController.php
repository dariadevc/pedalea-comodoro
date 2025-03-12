<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;

class PagoController extends Controller
{
    public function procesarPago(Request $request)
    {
        $request->validate([
            'monto' => 'required|numeric|min:1|max:100000',
        ], [
            'monto.required' => 'El monto es obligatorio.',
            'monto.numeric' => 'El monto debe ser un número.',
            'monto.min' => 'El monto mínimo es de $1',
            'monto.max' => 'El monto máximo es de $100.000'
        ]);

        session(['monto_pago' => intval($request->monto)]);

        // Configurar Mercado Pago
        MercadoPagoConfig::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));
        MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);

        // Crear preferencia de pago
        $client = new PreferenceClient();

        $preference = $client->create([
            "items" => [
                [
                    "title" => "Carga de saldo",
                    "quantity" => 1,
                    "currency_id" => "ARS",
                    "unit_price" => intval($request->monto)
                ]
            ],
            "back_urls" => [
                "success" => route('pago.exito'),
                "failure" => route('pago.error'),
                "pending" => route('pago.error'),
            ],
            "auto_return" => "approved"
        ]);

        if ($request->ajax()) {
            return response()->json(['redirect' => $preference->init_point]);
        } else {
            return redirect($preference->init_point);
        }

    }

    public function exito()
    {
        $monto = session('monto_pago');
        session()->forget('monto_pago');
        /** @var \App\Models\User $usuario */
        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();
        $cliente->agregarSaldo($monto, 'Carga de saldo');
        $saldo = $cliente->saldo;
        return redirect()->route('inicio')->with('success', "Carga realizada con éxito. Su saldo actual es de \${$saldo}");
    }
    
    public function error()
    {
        return redirect()->route('inicio')->with('error', 'No se pudo realizar la carga. Intente nuevamente.');
    }
}
