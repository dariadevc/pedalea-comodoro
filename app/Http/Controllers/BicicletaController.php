<?php

namespace App\Http\Controllers;

use App\Models\Bicicleta;
use App\Models\Estacion;
use App\Models\EstadoBicicleta;
use App\Models\EstadoMulta;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\ElseIf_;

use function Laravel\Prompts\alert;

class BicicletaController extends Controller
{
    public function index()
    {
        $bicicletas = Bicicleta::with(['estado', 'estacionActual'])->get();
        return view('bicicletas.index', compact('bicicletas'));
    }

    public function create()
    {
        $estados = EstadoBicicleta::all();
        $estaciones = Estacion::where('id_estado', 1)->get();
        return view('bicicletas.create', compact('estados', 'estaciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'estacion' => 'required|integer',
            'estado' => 'required|integer',
        ]);

        Bicicleta::create([
            'id_estado' => $request->input('estado'),
            'id_estacion_actual' => $request->input('estacion') == '0' ? null : $request->input('estacion'),
        ]);

        return redirect()->route('bicicletas.index')->with('success', 'Bicicleta creada exitosamente.');

    }

    public function edit(Bicicleta $bicicleta)
    {
        $existe_bicicletas_en_reserva = $bicicleta->reservas()->whereIn('id_estado', [1, 2, 5, 6])->exists();
        if ($existe_bicicletas_en_reserva) {
            return redirect()->route('bicicletas.index')->with('error', 'No se puede editar la bicicleta. Está asociada a una reserva.');
        } else {
            $estados = EstadoBicicleta::all();
            $estaciones = Estacion::where('id_estado', 1)->get();
            return view('bicicletas.edit', compact('bicicleta', 'estados', 'estaciones'));
        }

    }

    public function update(Request $request, Bicicleta $bicicleta)
    {
        $request->validate([
            'estacion' => 'required|integer',
            'estado' => 'required|integer',
        ]);

        if ($request->input('estacion') == '0') {
            $bicicleta->id_estacion_actual = null;
        } else {
            $estacion_inactiva = Estacion::where('id_estado', 2)->where('id_estacion', $request->estacion)->exists();
            if ($estacion_inactiva) {
                return redirect()->back()->with('error', 'La estación seleccionada no está habilitada.');
            }
            $bicicleta->id_estacion_actual = $request->input('estacion');
        }

        $bicicleta->id_estado = $request->input('estado');

        $bicicleta->save();
        return redirect()->route('bicicletas.index')->with('success', 'Bicicleta actualizada correctamente');
    }

    public function destroy(Bicicleta $bicicleta)
    {
        $existe_bicicleta_en_reservas = $bicicleta->reservas()->whereIn('id_estado', [1, 2, 5, 6])->exists();
        if ($existe_bicicleta_en_reservas) {
            return redirect()->route('bicicletas.index')->with('error', 'No se puede eliminar la bicicleta. Está asociada a una reserva.');
        } else {
            $bicicleta->delete();
            return redirect()->route('bicicletas.index')->with('success', 'Bicicleta eliminada correctamente');
        }
    }
    public function deshabilitar(Request $request)
{
    $request->validate([
        'patente' => 'required|string',
    ]);

    // Buscar la bicicleta por patente
    $bicicleta = Bicicleta::where('patente', $request->input('patente'))->first();

    if (!$bicicleta) {
        return redirect()->back()->with('error', 'La bicicleta no fue encontrada.');
    }

    if ($bicicleta->id_estado == 2)
    {
        return redirect()->back()->with('error', 'La bicicleta ya está deshabilitada.');
    }
    $existe_bicicletas_en_reserva = $bicicleta->reservas()->whereIn('id_estado', [1, 2, 5, 6])->exists();
    if ($existe_bicicletas_en_reserva == true)
    {
        return redirect()->route('inspector.bicicletas')->with('error', 'No se puede deshabilitar la bicicleta. Está asociada a una reserva.');
    }
    else
    {
        $estadoDeshabilitado = 2; // Asegúrate de que este ID sea correcto
        $bicicleta->id_estado = $estadoDeshabilitado;
        $bicicleta->save();
        return redirect()->route('inspector.bicicletas')->with('success', 'Bicicleta deshabilitada correctamente.');
    }
}
    public function vistaDeshabilitar()
    {
        return view('inspector.bicicletas');
    }
}
