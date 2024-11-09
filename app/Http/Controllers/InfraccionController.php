<?php

namespace App\Http\Controllers;

use App\Models\Bicicleta;
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
        // ----------------------------
        // ----------------------------
        // ----------------------------

        // LORENZO RETORNA JSON CUANDO TRABAJES CON AJAX, SINO NO
        // AHORA TENES QUE RETORNAR UNA VISTA O REDIRIGIR A OTRA RUTA

        // ----------------------------
        // ----------------------------
        // ----------------------------

        $request->validate([
            'patente' => 'required|string',
            'motivo' => 'required|string',
            'puntos' => 'required|integer|min:0',
        ]);

        $bicicleta = Bicicleta::where('patente', $request->patente)->first();
        if (!$bicicleta) {
            return response()->json(['error' => 'Bicicleta no encontrada'], 404);
        }

        $reserva = $bicicleta->reservas()->whereIn('id_estado', [2, 6])->first();

        if (!$reserva) {
            return response()->json(['error' => 'No se encontró una reserva activa para esta bicicleta'], 404);
        }
        /** @var \App\Models\Cliente $cliente */
        $cliente = $reserva->clienteReservo;
        $cliente->infracciones()->create([
            'id_reserva' => $reserva->id_reserva,
            'id_usuario_inspector' => Auth::user()->id_usuario,
            'motivo' => $request->motivo,
            'cantidad_puntos'=> $request->puntos,
            'fecha_hora'=> Carbon::now(),
        ]);
        $puntaje_a_restar = $request->puntos * -1;
        $cliente->actualizarPuntaje($puntaje_a_restar);
        return response()->json(['success' => 'Infracción creada exitosamente.'], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
