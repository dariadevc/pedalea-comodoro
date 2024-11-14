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
                return redirect()->back()->with('success', 'Multa pagada correctamente');
            }
        }
    }
}
