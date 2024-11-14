<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdministrativoController extends Controller
{


    public function editTarifa()
    {
        $monto_tarifa = Configuracion::where('clave', 'tarifa')->value('valor');
        $ultima_fecha_modificacion_tarifa = Configuracion::where('clave', 'fecha_modificacion_tarifa')->value('valor');

        return view('administrativo.editTarifa', compact('monto_tarifa', 'ultima_fecha_modificacion_tarifa'));
    }
    public function updateTarifa(Request $request)
    {
        $request->validate([
            'monto' => 'required|numeric',
        ]);

        // Obtener la fecha actual
        $fecha_actual = now()->format('Y-m-d');


        Configuracion::where('clave', 'ultima_fecha_modificacion_tarifa')->update(['valor' => $fecha_actual]);

        // Actualizar el monto de la tarifa en la tabla de configuraciones
        Configuracion::where('clave', 'tarifa')->update(['valor' => $request->monto]);

        return redirect()->route('inicio')->with('message', 'Tarifa actualizada con éxito.');
    }
}
