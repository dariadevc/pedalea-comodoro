<?php

namespace App\Http\Controllers;

use App\Models\Estacion;
use Illuminate\View\View;
use App\Rules\HorarioRetiro;
use Illuminate\Http\Request;
use App\Models\EstadoEstacion;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class EstacionController extends Controller
{
    /**
     * Muestra el listado de estaciones.
     * 
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $estaciones = Estacion::with(['estado'])->get();
        return view('estaciones.index', compact('estaciones'));
    }


    /**
     * Muestra el formulario para crear una estación.
     * 
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        $estados = EstadoEstacion::all();
        return view('estaciones.create', compact('estados'));
    }

    /**
     * Almacena una nueva estación en la base de datos.
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'estado' => 'required|integer',
        ]);

        Estacion::create([
            'nombre' => $request->input('nombre'),
            'latitud' => $request->input('latitud'),
            'longitud' => $request->input('longitud'),
            'id_estado' => $request->input('estado'),
            'calificacion' => 0.00,
        ]);

        return redirect()->route('estaciones.index')->with('success', 'Estación creada correctamente.');
    }


    /**
     * Muestra el formulario para editar una estación o redirige si hay una reserva asociada a la estación.
     * 
     * @param Estacion $estacion
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Estacion $estacion)
    {
        $existe_reservas_devolucion_en_estacion = $estacion->reservasDevolucion()->whereIn('id_estado', [1, 2, 5, 6])->exists();
        $existe_reservas_retiro_en_estacion = $estacion->reservasRetiro()->whereIn('id_estado', [1, 2, 5, 6])->exists();

        if ($existe_reservas_devolucion_en_estacion || $existe_reservas_retiro_en_estacion) {
            return redirect()->back()->with('error', 'No se puede deshabilitar la estación. Está asociada a reservas.');
        } else {
            $estados = EstadoEstacion::all();
            return view('estaciones.edit', compact('estacion', 'estados'));
        }
    }


    /**
     * Actualiza una estación en la base de datos.
     *
     * @param Estacion $estacion
     * @param Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Estacion $estacion): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'estado' => 'required|integer',
        ]);
        $estacion->nombre = $request->input('nombre');
        $estacion->latitud = $request->input('latitud');
        $estacion->longitud = $request->input('longitud');
        $estacion->id_estado = $request->input('estado');

        $estacion->save();
        return redirect()->route('estaciones.index')->with('success', 'Estación actualizada correctamente');
    }

    /**
     * Elimina suavemente (soft delete) una estación de la base de datos.
     *
     * @param Estacion $estacion
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Estacion $estacion): RedirectResponse
    {
        $tiene_reservas_con_devolucion = $estacion->reservasDevolucion()->whereIn('id_estado', [1, 2, 5, 6])->exists();
        $tiene_reservas_con_retiro = $estacion->reservasRetiro()->whereIn('id_estado', [1, 2, 5, 6])->exists();


        $bicicletas = $estacion->bicicletas;
        $bicicletas_con_reservas = $bicicletas->filter(function ($bicicleta) {
            return $bicicleta->reservas()->whereIn('id_estado', [1, 2, 5, 6])->exists();
        });

        if ($tiene_reservas_con_devolucion || $tiene_reservas_con_retiro || $bicicletas_con_reservas->isNotEmpty()) {
            return redirect()->back()->with('error', 'No se puede eliminar la estación. Tiene reservas activas o bicicletas asociadas con reservas.');
        }

        $estacion->delete();
        return redirect()->route('estaciones.index')->with('success', 'Estación eliminada correctamente.');
    }


    /**
     * Obtener las estaciones disponibles con sus bicicletas disponibles.
     * Se utiliza una consulta sql y devuelve una colección de estaciones.
     * 
     * @return \Illuminate\Database\Eloquent\Collection<\App\Models\Estacion>
     */
    public function getEstacionesDisponiblesParaVerMapa()
    {
        $estacionesConBicicletasDisponibles = Estacion::where('id_estado', 1)
            ->select('nombre', 'latitud', 'longitud')
            ->withCount(['bicicletas as cantidad_bicicletas_disponibles' => function ($query) {
                $query->where('id_estado', 1)
                    ->whereDoesntHave('reservas', function ($subQuery) {
                        $subQuery->whereIn('id_estado', [1, 2, 5, 6]);
                    });
            }])
            ->get();


        return $estacionesConBicicletasDisponibles;
    }

    /**
     * Muestra el mapa de estaciones.
     * 
     * @return \Illuminate\View\View
     */
    public function verMapaCliente(): View
    {
        $estaciones = $this->getEstacionesDisponiblesParaVerMapa();
        return view('cliente.ver-mapa', compact('estaciones'));
    }

    /**
     * Obtener estaciones en el horario de retiro seleccionado.
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function disponibilidadHorarioRetiro(Request $request): JsonResponse
    {
        $validador = Validator::make($request->all(), [
            'horario_retiro' => ['required', new HorarioRetiro],
        ], [
            'horario_retiro.required' => 'El horario de retiro es obligatorio.',
        ]);

        if ($validador->fails()) {
            // Si hay errores, devolvemos los mensajes como JSON con el código de estado 422
            return response()->json(['errors' => $validador->errors()], 422);
        }


        $estaciones = Estacion::where('id_estado', 1)->get();
        $estaciones_disponibles = [];
        $estaciones_devolucion = [];
        $horario_retiro = $request->input('horario_retiro');

        foreach ($estaciones as $estacion) {
            $estaciones_devolucion[] = [
                'id_estacion' => $estacion->id_estacion,
                'nombre' => $estacion->nombre,
            ];
            if ($estacion->hayDisponibilidadEnEstaHora($horario_retiro) || $estacion->hayDisponibilidadAhora()) {
                $estaciones_disponibles[] = [
                    'id_estacion' => $estacion->id_estacion,
                    'nombre' => $estacion->nombre,
                ];
            }
        }

        return response()->json([
            'success' => true,
            'mensaje' => $request->input('horario_retiro'),
            'estaciones_disponibles' => $estaciones_disponibles,
            'estaciones_devolucion' => $estaciones_devolucion
        ]);
    }
}
