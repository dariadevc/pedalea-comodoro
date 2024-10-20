<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Estacion;


class EstacionController extends Controller
{
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
                DB::raw('COUNT(b.id_bicicleta) AS cantidad_bicicletas_disponibles')
            )
            ->leftJoin('bicicletas as b', 'b.id_estacion_actual', '=', 'e.id_estacion')
            ->leftJoin('reservas as r', function ($join) {
                $join->on('r.id_bicicleta', '=', 'b.id_bicicleta')
                    ->whereIn('r.id_estado', [1, 2, 5, 6]); // Estados: Alquilada, Activa, Reasignada, Modificada
            })
            ->where('e.id_estado', 1) // Estaciones habilitadas
            ->whereNull('r.id_bicicleta') // Excluir bicicletas en reservas activas
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
        
        $cantidadNoDisponibles = $estacion->verificarDisponibilidad($horario_retiro);

        $cantidadBicisDisponibles= $estacion->calcularBicisDisponibles($cantidadNoDisponibles);

        if ($cantidadBicisDisponibles>0){
            $estacionesDisponibles[]=$estacion;
        }
    }
    //dd($estacionesDisponibles);
    
    return view('cliente.pruebaview')->with('estacionesDisponibles', $estacionesDisponibles);
    }
}
