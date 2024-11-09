<?php

namespace App\Http\Controllers;


use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class InformeController extends Controller
{

    /**
     * Muestra el menu para los informes.
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function informeMenu(): View
    {
        return view('informes.menuInformes');
    }


    /**
     * Muestra el informe de multas.
     * 
     * @param Request $request
     * 
     * @return \Illuminate\View\View
     */
    public function informeMultas(Request $request): View
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
        } else {
            $multas = [];
        }
        return view('informes.multas', compact('multas'));
    }


    //De la otra forma con la lista y el validatte, tendria que probar con date_format, no con date solo.
    /**
     * Muestra el informe de estaciones.
     * 
     * @param Request $request
     * 
     * @return \Illuminate\View\View
     */
    public function informeEstaciones(Request $request): View
    {
        $fechaInicio = $request->input('fecha_inicio') . ' 00:00:00';
        $fechaFin = $request->input('fecha_fin') . ' 23:59:59';

        if ($fechaInicio && $fechaFin) {
            $estaciones = DB::table('reservas')
                ->select(DB::raw('id_estacion_retiro, estaciones.nombre, COUNT(*) as total_reservas')) //DB::RAW sirve para utilizar funciones SQL que laravel no tiene
                ->join('estaciones', 'reservas.id_estacion_retiro', '=', 'estaciones.id_estacion')
                ->whereBetween(DB::raw('DATE(fecha_hora_devolucion)'), [$fechaInicio, $fechaFin])
                ->groupBy('id_estacion_retiro', 'nombre')
                ->orderBy('total_reservas', 'desc')
                ->where('reservas.id_estado', 3)
                ->get();
        } else {
            $estaciones = [];
        }
        return view('informes.estacionesInforme', compact('estaciones'));
    }

    /**
     * Muestra el informe de rutas.
     * 
     * @param Request $request
     * 
     * @return \Illuminate\View\View
     */
    public function informeRutas(Request $request): View
    {
        $fechaInicio = $request->input('fecha_inicio') . ' 00:00:00';
        $fechaFin = $request->input('fecha_fin') . ' 23:59:59';

        if ($fechaInicio && $fechaFin) {
            $rutas = DB::table('reservas')
                ->select(DB::raw('CONCAT(reservas.id_estacion_retiro, " -> ", reservas.id_estacion_devolucion) as rutas, r.nombre as nombreR,d.nombre as nombreD , COUNT(*) as total'))
                ->join('estaciones as r', 'reservas.id_estacion_retiro', "=", 'r.id_estacion')
                ->join('estaciones as d', 'reservas.id_estacion_devolucion', "=", 'd.id_estacion')
                ->whereBetween(DB::raw('DATE(fecha_hora_devolucion)'), [$fechaInicio, $fechaFin])
                ->groupBy('id_estacion_retiro', 'id_estacion_devolucion', 'r.nombre', 'd.nombre')
                ->orderBy('total', 'desc')
                ->where('reservas.id_estado', 3)
                ->get();
        } else {
            $rutas = [];
        }
        return view('informes.rutasInforme', compact('rutas'));
    }


    /**
     * Muestra el informe del tiempo de alquiler de mayor demanda y el horario de retiro de mayor demanda.
     * 
     * @param Request $request
     * 
     * @return \Illuminate\View\View
     */
    public function informeTiempoAlquilerHorarioDemanda(Request $request): View
    {
        $fechaInicio = $request->input('fecha_inicio') . ' 00:00:00';
        $fechaFin = $request->input('fecha_fin') . ' 23:59:59';

        if ($fechaInicio && $fechaFin) {
            $alquileresTime = DB::table('reservas')
                ->select(DB::raw('CONCAT(TIMESTAMPDIFF(HOUR, fecha_hora_retiro, fecha_hora_devolucion), " hs ") as tiempo, COUNT(*) cant'))
                ->whereBetween(DB::raw('DATE(fecha_hora_devolucion)'), [$fechaInicio, $fechaFin])
                ->groupBy('tiempo')
                ->orderBy('cant', 'desc')
                ->where('reservas.id_estado', 3)
                ->get();

            $totalReservas = DB::table('reservas') //Consulta para contar y despues usarlo en alquileresHor para obtener el %.
                ->whereBetween(DB::raw('DATE(fecha_hora_retiro)'), [$fechaInicio, $fechaFin])
                ->where('reservas.id_estado', 3)
                ->count();

            $alquileresHor = DB::table('reservas')
                ->select(DB::raw('CONCAT(HOUR(fecha_hora_retiro), " hs ") as hora, COUNT(*) as cant_horas, ROUND(COUNT(*) / ' . $totalReservas . ' * 100, 2) as porcentaje'))
                ->whereBetween(DB::raw('DATE(fecha_hora_devolucion)'), [$fechaInicio, $fechaFin])
                ->groupBy('hora')
                ->orderBy('cant_horas', 'desc')
                ->where('reservas.id_estado', 3)
                ->get();
        } else {

            $alquileresTimeHor = [];
            $alquileresTime = [];
        }
        return view('informes.alquilerInforme', compact('alquileresTime', 'alquileresHor'));
    }
}
