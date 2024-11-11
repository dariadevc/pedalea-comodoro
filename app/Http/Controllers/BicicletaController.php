<?php

namespace App\Http\Controllers;

use App\Models\Estacion;
use App\Models\Bicicleta;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\EstadoBicicleta;
use Illuminate\Http\RedirectResponse;

use function Laravel\Prompts\alert;

class BicicletaController extends Controller
{
    /**
     * Muestra el listado de bicicletas.
     * 
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $bicicletas = Bicicleta::with(['estado', 'estacionActual'])->get();
        return view('bicicletas.index', compact('bicicletas'));
    }

    /**
     * Muestra el formulario para crear una bicicleta.
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $estados = EstadoBicicleta::all();
        $estaciones = Estacion::where('id_estado', 1)->get();
        return view('bicicletas.create', compact('estados', 'estaciones'));
    }

    /**
     * Almacena una nueva bicicleta en la base de datos.
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
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

    /**
     * Muestra el formulario para editar una bicicleta.
     * 
     * @param Bicicleta $bicicleta
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Bicicleta $bicicleta)
    {
        $existe_bicicleta_en_reservas = $bicicleta->reservas()->whereIn('id_estado', [1, 2, 5, 6])->exists();
        if ($existe_bicicleta_en_reservas) {
            return redirect()->route('bicicletas.index')->with('error', 'No se puede editar la bicicleta. Está asociada a una reserva.');
        } else {
            $estados = EstadoBicicleta::all();
            $estaciones = Estacion::where('id_estado', 1)->get();
            return view('bicicletas.edit', compact('bicicleta', 'estados', 'estaciones'));
        }
    }


    /**
     * Actualiza una bicicleta en la base de datos.
     * 
     * @param Bicicleta $bicicleta
     * @param Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Bicicleta $bicicleta): RedirectResponse
    {
        $request->validate([
            'estacion' => 'required|integer',
            'estado' => 'required|integer',
        ]);

        if ($request->input('estacion') == '0') {
            $id_estacion_actual = null;
        } else {
            $estacion_inactiva = Estacion::where('id_estado', 2)->where('id_estacion', $request->estacion)->exists();
            if ($estacion_inactiva) {
                return redirect()->back()->with('error', 'La estación seleccionada no está habilitada.');
            }
            $id_estacion_actual = $request->input('estacion');
        }
        $id_estado = $request->input('estado');

        $bicicleta->editar($id_estado, $id_estacion_actual);

        return redirect()->route('bicicletas.index')->with('success', 'Bicicleta actualizada correctamente');
    }


    /**
     * Elimina suavemente (soft delete) una bicicleta de la base de datos.
     * 
     * @param Bicicleta $bicicleta
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Bicicleta $bicicleta): RedirectResponse
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
