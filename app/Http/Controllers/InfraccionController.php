<?php

namespace App\Http\Controllers;

use App\Models\Bicicleta;
use App\Models\EstadoReserva;
use App\Models\Infraccion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InfraccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $infraccion = Infraccion::with(['reserva', 'cliente', 'inspector'])->get();
        return view('inspector.infraccion', compact('infraccion'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function generarInfraccion(Request $request)
    {

        $request->validate([
            'patente' => 'required|string',
            'motivo' => 'required|string',
            'puntos' => 'required|integer|min:0',
        ]);

        $bicicleta = Bicicleta::where('patente', $request->patente)->first();
        if (!$bicicleta) {
            return redirect()->back()->with('error', 'Bicicleta no encontrada')->withInput();
        }

        $reserva = $bicicleta->reservas()->whereIn('id_estado', [EstadoReserva::ALQUILADA, EstadoReserva::REASIGNADA])->first();

        if (!$reserva) {
            return redirect()->back()->with('error', 'No se encontró una reserva activa para esta bicicleta')->withInput();
        }
        if ($request->puntos > 0) {
            $puntos_a_restar = $request->puntos * -1;
        }

        /** @var \App\Models\Cliente $cliente */
        $cliente = $reserva->clienteReservo;
        $cliente->infracciones()->create([
            'id_reserva' => $reserva->id_reserva,
            'id_usuario_inspector' => Auth::user()->id_usuario,
            'motivo' => $request->motivo,
            'cantidad_puntos'=> $puntos_a_restar,
            'fecha_hora'=> Carbon::now(),
        ]);
        $cliente->actualizarPuntaje($puntos_a_restar);
        return redirect()->route('inicio')->with('success', 'Infracción creada exitosamente.');
    }
}
