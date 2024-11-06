<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdministrativoController extends Controller
{
    public function editTarifa()
    {
        $tarifa = Configuracion::where('clave', 'tarifa')
            ->orWhere('clave', 'fecha_modificacion_tarifa')
            ->get();
        return view('administrativo.editTarifa', compact('tarifa'));
    }
    public function updateTarifa(Request $request) 
    {
        $request->validate([
            'monto' => 'required|numeric',
        ]);
        
        // Obtener la fecha actual
        $fecha_actual = now()->format('Y-m-d');

        
        // Actualizar la fecha de modificación de la tarifa en la tabla de configuraciones
        Configuracion::where('clave', 'fecha_modificacion_tarifa')->update(['valor' => $fecha_actual]);
        
        // Actualizar el monto de la tarifa en la tabla de configuraciones
        Configuracion::where('clave', 'tarifa')->update(['valor' => $request->monto]);

        return redirect()->route('inicio')->with('message', 'Tarifa actualizada con éxito.');
    }
}
