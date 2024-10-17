<?php

namespace App\Http\Controllers;

use App\Models\Bicicleta;
use App\Models\Estacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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


        // $estacionesConBicicletasDisponibles = Estacion::with(['bicicletas' => function ($query) {
        //     $query->whereDoesntHave('reservas', function ($subQuery) {
        //         $subQuery->whereIn('id_estado', [1, 2, 5, 6]); // Estados: Alquilada, Activa, Reasignada, Modificada
        //     });
        // }])
        //     ->where('id_estado', 1)
        //     ->select('id_estacion', 'nombre AS nombre_estacion', 'latitud', 'longitud')
        //     ->get()
        //     ->map(function ($estacion) {
        //         return [
        //             'nombre_estacion' => $estacion->nombre_estacion,
        //             'latitud' => $estacion->latitud,
        //             'longitud' => $estacion->longitud,
        //             'cantidad_bicicletas_disponibles' => $estacion->bicicletas->count(),
        //         ];
        //     });

        return response()->json($estacionesConBicicletasDisponibles);
    }
}
