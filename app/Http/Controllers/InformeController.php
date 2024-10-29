<?php

namespace App\Http\Controllers;

use App\Models\Multa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\Count;

class InformeController extends Controller
{
    public function informe_multas(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio') . ' 00:00:00';  //Pongo de esta forma la hora para que me tome todo el dia
        $fechaFin = $request->input('fecha_fin') . ' 23:59:59';        //Si no ponia la misma fecha de inicio y de fin y no me filtraba por el cambio de horario

        if ($fechaInicio && $fechaFin) {
            $multas = DB::table('multas') //Tengo que hacer esta consulta para obtener el nombre de cada cliente que esta en la clase padre user. 
                        ->select('multas.*', 'usuarios.nombre as nombre_usuario')
                        ->join('clientes', 'multas.id_usuario', '=', 'clientes.id_usuario')
                        ->join('usuarios', 'clientes.id_usuario', '=', 'usuarios.id_usuario')
                        ->whereBetween('multas.fecha_hora', [$fechaInicio, $fechaFin])
                        ->get();

        }else{

            $multas = [];
        }
        return view('informes.multas', compact('multas'));
    }

//De la otra forma con la lista y el validatte, tendria que probar con date_format, no con date solo.

    public function informe_estaciones (Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio') . ' 00:00:00';
        $fechaFin = $request->input('fecha_fin') . ' 23:59:59'; 

        if($fechaInicio && $fechaFin)
        {
            $estaciones = DB::table('reservas')
            ->select(DB::raw('id_estacion_retiro, estaciones.nombre, COUNT(*) as total_reservas')) //DB::RAW sirve para utilizar funciones SQL que laravel no tiene
            ->join('estaciones', 'reservas.id_estacion_retiro' ,'=', 'estaciones.id_estacion')
            ->whereBetween(DB::raw('DATE(fecha_hora_devolucion)'), [$fechaInicio, $fechaFin])
            ->groupBy('id_estacion_retiro', 'nombre')
            ->orderBy('total_reservas', 'desc')
            ->where('reservas.id_estado', 3)
            ->get();

        }else{
            $estaciones = [];
        }
        return view('informes.estacionesInforme', compact('estaciones'));

    }

    public function informe_rutas (Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio') . ' 00:00:00';
        $fechaFin = $request->input('fecha_fin') . ' 23:59:59'; 

        if ($fechaInicio && $fechaFin)
        {
            $rutas = DB::table('reservas')
            ->select(DB::raw('CONCAT(reservas.id_estacion_retiro, " -> ", reservas.id_estacion_devolucion) as rutas, CONCAT(r.nombre, " -> " ,d.nombre) as nombresEST, COUNT(*) as total'))
            ->join('estaciones as r', 'reservas.id_estacion_retiro', "=", 'r.id_estacion')
            ->join('estaciones as d', 'reservas.id_estacion_devolucion', "=", 'd.id_estacion')
            ->whereBetween(DB::raw('DATE(fecha_hora_devolucion)'), [$fechaInicio, $fechaFin])
            ->groupBy('id_estacion_retiro', 'id_estacion_devolucion', 'r.nombre' ,'d.nombre')
            ->orderBy('total', 'desc')
            ->where('reservas.id_estado', 3)
            ->get();

        }else {

            $rutas = [];

        }
        return view('informes.rutasInforme', compact('rutas'));
    }
    
}














