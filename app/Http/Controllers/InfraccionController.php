<?php

namespace App\Http\Controllers;

use App\Models\Bicicleta;
use App\Models\Infraccion;
use App\Models\Reserva;
use App\Models\Cliente;
use App\Models\Inspector;
use Illuminate\Http\Request;

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
        // Validar los datos del formulario
        $request->validate([
            'patente' => 'required|string',
            'descripcion' => 'required|string',
            'puntos' => 'required|integer|min:0',
        ]);
        //Encontrar la bicicleta para encontrar la reserva y posteriormente encontrar al cliente.
        $bicicleta = Bicicleta::where('patente', $request->patente)->first();
        //Validamos que exista esa bicicleta.
        if (!$bicicleta) {
            return response()->json(['error' => 'Bicicleta no encontrada'], 404);
        }
        // Encontramos la reserva activa asociada a la bicicleta.
        $reserva = $bicicleta->reservas()->whereIn('id_estado', [1, 2, 5, 6])->first();
        // Validar si la reserva existe.
        if (!$reserva) {
            return response()->json(['error' => 'No se encontró una reserva activa para esta bicicleta'], 404);
        }
        Infraccion::create([
            'id_reserva' => $reserva->id_reserva,
            'id_usuario_cliente' => $reserva->id_cliente_reservo,
            'descripcion' => $request->descripcion,
            //'cantidad_puntos'->puntos = $request->puntos,
            //'fecha_hora'->fecha = Carbon::now(), // Asignar la fecha actual
        ]);
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
