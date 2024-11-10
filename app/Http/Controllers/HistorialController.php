<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HistorialController extends Controller
{

    public function historialReservas(Request $request)  //Metodo para el historial de reservas
    {
    $usuario = Auth::user();
    $cliente = $usuario->obtenerCliente();

        $fechaInicio = $request->input('fecha_inicio') . ' 00:00:00';
        $fechaFin = $request->input('fecha_fin') . ' 23:59:59';
        
        if ($fechaInicio && $fechaFin) {
        $reservas = DB::table('reservas')
            ->join('bicicletas', 'reservas.id_bicicleta', '=', 'bicicletas.id_bicicleta')
            ->join('estaciones as estacion_retiro', 'reservas.id_estacion_retiro', '=', 'estacion_retiro.id_estacion')
            ->join('estaciones as estacion_devolucion', 'reservas.id_estacion_devolucion', '=', 'estacion_devolucion.id_estacion')
            ->join('estados_reserva', 'reservas.id_estado', '=', 'estados_reserva.id_estado')
            ->select(
                'reservas.id_reserva', 'reservas.fecha_hora_retiro', 'reservas.fecha_hora_devolucion', 
                'bicicletas.patente as bicicleta_patente', 
                'estacion_retiro.nombre as estacion_retiro_nombre', 
                'estacion_devolucion.nombre as estacion_devolucion_nombre', 
                'estados_reserva.nombre as estado', 
                'reservas.puntaje_obtenido as puntaje'
            )
            ->where('reservas.id_cliente_reservo', $cliente->id_usuario)
            ->whereBetween('reservas.fecha_hora_retiro', [$fechaInicio, $fechaFin])
            ->whereIn('reservas.id_estado', [1, 2, 3, 4])
            ->paginate(10);
        } else {
            $reservas = collect(); // Colección vacía si no hay fechas válidas
        }

        return view('historiales.reservasHistorial', compact('reservas', 'fechaInicio', 'fechaFin'));
}


    //Historial de Multas:
    public function historialMultas(Request $request)
    {
        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();
    
        $fechaInicio = $request->input('fecha_inicio') . ' 00:00:00';
        $fechaFin = $request->input('fecha_fin') . ' 23:59:59';
    
        if ($fechaInicio && $fechaFin) {
            $multas = DB::table('multas')
                ->select('multas.monto','multas.fecha_hora','multas.descripcion','estados_multa.nombre as estadoName')
                ->join('estados_multa','multas.id_estado', "=" , 'estados_multa.id_estado')
                ->where('multas.id_usuario', $cliente->id_usuario)
                ->whereBetween('multas.fecha_hora', [$fechaInicio, $fechaFin])
                ->whereIn('multas.id_estado', [1, 2])
                ->paginate(10); //Muestra los primeros 10 resultados 
        } else {
            $multas = [];
        }
    
        return view('historiales.multasHistorial', compact('multas', 'fechaInicio', 'fechaFin'));
    }

    //Historial de Suspensiones:
    public function historialSuspensiones(Request $request)
    {
        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();
    
        $fechaInicio = $request->input('fecha_inicio') . ' 00:00:00';
        $fechaFin = $request->input('fecha_fin') . ' 23:59:59';
    
        if ($fechaInicio && $fechaFin) {
            $suspensiones = DB::table('suspensiones')
                ->select('suspensiones.fecha_desde','suspensiones.fecha_hasta','suspensiones.fecha_hora','suspensiones.descripcion', 'estados_suspension.nombre as estado')
                ->join('estados_suspension','suspensiones.id_estado', "=" , 'estados_suspension.id_estado')
                ->where('suspensiones.id_usuario', $cliente->id_usuario)
                ->whereBetween('suspensiones.fecha_desde', [$fechaInicio, $fechaFin])
                ->whereIn('suspensiones.id_estado', [1, 2])
                ->paginate(1); //Muestra los primeros 10 resultados 
        } else {
            $suspensiones = [];
        }
    
        return view('historiales.suspensionesHistorial', compact('suspensiones', 'fechaInicio', 'fechaFin'));
    }

    //Historial Movimientos:
    public function historialMovimientos(Request $request)
    {
        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();
    
    
        if ($cliente) {
            $movimientos = DB::table('historiales_saldo')
                ->select('historiales_saldo.fecha_hora','historiales_saldo.monto','historiales_saldo.motivo')
                ->where('historiales_saldo.id_usuario', $cliente->id_usuario)
                ->orderBy('fecha_hora', "desc")
                ->paginate(10); //Muestra los primeros 10 resultados 
        } else {
            $movimientos = [];
        }
    
        return view('historiales.saldoHistorial', compact('movimientos'));
    }
}


