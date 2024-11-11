<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Configuracion;
use Illuminate\Http\RedirectResponse;

class AdministrativoController extends Controller
{

    /**
     * Muestra el formulario para editar la tarifa.
     * 
     * @return \Illuminate\View\View
     */
    public function editTarifa(): View
    {
        $tarifa = Configuracion::where('clave', 'tarifa')
            ->orWhere('clave', 'ultima_fecha_modificacion_tarifa')
            ->get();

        return view('administrativo.editTarifa', compact('tarifa'));
    }

    /**
     * Actualiza la tarifa en la base de datos.
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateTarifa(Request $request): RedirectResponse
    {
        $request->validate([
            'monto' => 'required|numeric',
        ]);

        $fecha_actual = Carbon::now()->format('Y-m-d');

        Configuracion::where('clave', 'ultima_fecha_modificacion_tarifa')->update(['valor' => $fecha_actual]);

        Configuracion::where('clave', 'tarifa')->update(['valor' => $request->monto]);

        return redirect()->route('inicio')->with('message', 'Tarifa actualizada con éxito.');
    }
}
