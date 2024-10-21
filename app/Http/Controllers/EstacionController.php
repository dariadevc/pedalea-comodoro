<?php

namespace App\Http\Controllers;

use App\Models\Estacion;
use App\Models\EstadoEstacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class EstacionController extends Controller
{
    public function index()
    {
        $estaciones = Estacion::with(['estado'])->get();
        return view('estaciones.index', ['estaciones' => $estaciones]);
    }

    public function create()
    {
        $estados = EstadoEstacion::all();
        return view('estaciones.create', compact('estados'));
    }

    public function store(Request $request)
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

    public function update(Request $request, Estacion $estacion)
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

    public function destroy(Estacion $estacion)
    {
    $tiene_reservas_con_devolucion = $estacion->reservasDevolucion()->whereIn('id_estado', [1, 2, 5, 6])->exists();
    $tiene_reservas_con_retiro = $estacion->reservasRetiro()->whereIn('id_estado', [1, 2, 5, 6])->exists();


    $bicicletas = $estacion->bicicletas; // Obtiene las bicicletas asociadas a la estación
    $bicicletas_con_reservas = $bicicletas->filter(function ($bicicleta) {
        return $bicicleta->reservas()->whereIn('id_estado', [1, 2, 5, 6])->exists();
    });

    if ($tiene_reservas_con_devolucion || $tiene_reservas_con_retiro || $bicicletas_con_reservas->isNotEmpty()) {
        return redirect()->back()->with('error', 'No se puede eliminar la estación. Tiene reservas activas o bicicletas asociadas con reservas.');
    }

    $estacion->delete();
    return redirect()->route('estaciones.index')->with('success', 'Estación eliminada correctamente.');
    }



    public function getEstacionesMapa()
    {
        // CONSULTA SQL PARA TENER LAS ESTACIONES CON BICICLETAS DISPONIBLES

        //         SELECT
        //     e.nombre AS nombre_estacion,
        //     e.latitud,
        //     e.longitud,
        //     COUNT(b.id_bicicleta) AS cantidad_bicicletas_disponibles
        // FROM
        //     estaciones e
        // LEFT JOIN bicicletas b ON
        //     b.id_estacion_actual = e.id_estacion
        // LEFT JOIN reservas r ON
        //     r.id_bicicleta = b.id_bicicleta AND r.id_estado IN(1, 2, 5, 6) -- Estados: Alquilada, Activa, Reasignada, Modificada
        // WHERE
        //     e.id_estado = 1
        //  AND r.id_bicicleta IS NULL -- Excluir bicicletas en reservas activas
        // GROUP BY
        //     e.id_estacion,
        //     e.nombre;

        $estacionesConBicicletasDisponibles = DB::table('estaciones as e')
            ->select(
                'e.nombre',
                'e.latitud',
                'e.longitud',
                DB::raw('COUNT(b.id_bicicleta) - COUNT(r.id_bicicleta) AS cantidad_bicicletas_disponibles')
            )
            ->leftJoin('bicicletas as b', 'b.id_estacion_actual', '=', 'e.id_estacion')
            ->leftJoin('reservas as r', function ($join) {
                $join->on('r.id_bicicleta', '=', 'b.id_bicicleta')
                    ->whereIn('r.id_estado', [1, 2, 5, 6]);
            })
            ->where('e.id_estado', 1)
            ->groupBy('e.id_estacion', 'e.nombre', 'e.latitud', 'e.longitud')
            ->get();

        return response()->json($estacionesConBicicletasDisponibles);
    }

    //el horario de retiro debe ser uno validado en el formulario, en el momento en que llena el formulario, con javascript..
    //A partir de tener un horario de retiro validado, este método comenzará a funcionar 
    
    
        /* Pseudocódigo que debe hacer el módulo estaciones_disponibles_reservar
        estaciones ; array de objetos estaciones
        estacionesDisponibles ; array vacío que se va a ir llenando con las estaciones que determinemos que estan disponibles
        for (estaciones){
            cantidadNoDisponibles = estacion.verificarDisponibilidad(horario_retiro)
            cantidad = estacion.calcularBicisDisponibles(cantidadNoDisponibles)
            
            if (cantidad>0){
            estacionesDisponibles.add(estacion)
            }
        }

        return estacionesDisponibles;

        */

    public function buscarDisponibilidad(\DateTime $horario_retiro)
    {
        $horario_retiro = new \DateTime("2023-11-17 15:00:00"); //Dato de prueba
       
       /* Descomentar, cuando venga un \DateTime como parametro.
        $horario_retiro = $horario_retiro->format('Y-m-d H:i:s');
        */

        //dd($horario_retiro);
        $estaciones = Estacion::all();
        $estacionesDisponibles = [];

        foreach ($estaciones as $estacion) {
        $cantidadBicisDisponibles=0;
        $cantidadNoDisponibles = $estacion->verificarDisponibilidad($horario_retiro);

        $cantidadBicisDisponibles= $estacion->calcularBicisDisponibles($cantidadNoDisponibles);
       
       // dump($estacion->id_estacion."   ".$cantidadBicisDisponibles);

        if ($cantidadBicisDisponibles>0){   
            $estacionesDisponibles[]=$estacion;
        }
    }
    //dd($estacionesDisponibles);

    
    return view('cliente.pruebaview')->with('estacionesDisponibles', $estacionesDisponibles);
    }
}
