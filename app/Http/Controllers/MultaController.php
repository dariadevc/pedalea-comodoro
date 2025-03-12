<?php

namespace App\Http\Controllers;

use App\Models\EstadoMulta;
use App\Models\Multa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MultaController extends Controller
{
    public function pagar(Multa $multa)
    {
        if ($multa->id_usuario == Auth::user()->id_usuario) {
            /** @var \App\Models\User $usuario */
            $usuario =  Auth::user();
            $cliente = $usuario->obtenerCliente();
            if ($multa->pagar($cliente)) {
                return response()->json([
                    'success' => true,
                    'mensaje' => 'Multa pagada con éxito.',
                    'id_multa' => $multa->id_multa,
                ]);
            } else {
                return response()->json([
                    'error' => 'No se pudo pagar la multa.',
                ], 400);
            }
        }
    }
}
