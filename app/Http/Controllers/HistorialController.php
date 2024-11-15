<?php

namespace App\Http\Controllers;

use App\Models\EstadoReserva;
use App\Models\User;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class HistorialController extends Controller
{

    public function historialReservas(Request $request)  //Metodo para el historial de reservas
    {
        /** @var \App\Models\User $usuario */
        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();

        $fechaInicio = $request->input('fecha_inicio') . ' 00:00:00';
        $fechaFin = $request->input('fecha_fin') . ' 23:59:59';


        if ($fechaInicio && $fechaFin) {
            // $reservas = $cliente->reservaReservo()
            //     ->with([
            //         'estacionRetiro',
            //         'estacionDevolucion:nombre',
            //         'estado:nombre',
            //         'clienteDevuelve.usuario:nombre,apellido'
            //     ])
            //     ->whereBetween('fecha_hora_retiro', [$fechaInicio, $fechaFin])
            //     ->orWhereIn('id_estado', [
            //         EstadoReserva::ACTIVA,
            //         EstadoReserva::MODIFICADA,
            //         EstadoReserva::ALQUILADA,
            //         EstadoReserva::REASIGNADA
            //     ])
            //     ->select('fecha_hora_retiro', 'fecha_hora_devolucion', 'puntaje_obtenido', 'monto')
            //     ->orderBy('fecha_hora_retiro', 'desc')
            //     ->paginate(10);
            $reservas = $cliente->reservaReservo()
                ->with([
                    'estacionRetiro:id_estacion,nombre',
                    'estacionDevolucion:id_estacion,nombre',
                    'estado:id_estado,nombre',
                    'clienteDevuelve.usuario:id_usuario,nombre,apellido'
                ])
                ->whereBetween('fecha_hora_retiro', [$fechaInicio, $fechaFin])
                ->orWhereIn('id_estado', [
                    EstadoReserva::ACTIVA,
                    EstadoReserva::MODIFICADA,
                    EstadoReserva::ALQUILADA,
                    EstadoReserva::REASIGNADA
                ])
                ->select('id_reserva', 'fecha_hora_retiro', 'fecha_hora_devolucion', 'puntaje_obtenido', 'monto', 'id_estacion_retiro', 'id_estacion_devolucion', 'id_estado', 'id_cliente_devuelve')
                ->orderBy('fecha_hora_retiro', 'desc')
                ->paginate(10);




            // dump($reservas);


            // $reservas = DB::table('reservas')
            //     ->join('bicicletas', 'reservas.id_bicicleta', '=', 'bicicletas.id_bicicleta')
            //     ->join('estaciones as estacion_retiro', 'reservas.id_estacion_retiro', '=', 'estacion_retiro.id_estacion')
            //     ->join('estaciones as estacion_devolucion', 'reservas.id_estacion_devolucion', '=', 'estacion_devolucion.id_estacion')
            //     ->join('estados_reserva', 'reservas.id_estado', '=', 'estados_reserva.id_estado')
            //     ->select(
            //         'reservas.id_reserva',
            //         'reservas.fecha_hora_retiro',
            //         'reservas.fecha_hora_devolucion',
            //         'bicicletas.patente as bicicleta_patente',
            //         'estacion_retiro.nombre as estacion_retiro_nombre',
            //         'estacion_devolucion.nombre as estacion_devolucion_nombre',
            //         'estados_reserva.nombre as estado',
            //         'reservas.puntaje_obtenido as puntaje',
            //         'estados_reserva.nombre as estadoNombre'
            //     )
            //     ->where('reservas.id_cliente_reservo', $cliente->id_usuario)
            //     ->whereBetween('reservas.fecha_hora_retiro', [$fechaInicio, $fechaFin])
            //     ->whereIn('reservas.id_estado', [1, 2, 3, 4])
            //     ->orderBy('fecha_hora_devolucion', "desc")
            //     ->paginate(10);
        } else {
            $reservas = []; // Colección vacía si no hay fechas válidas
        }

        return view('cliente.historial_reservas', compact('reservas', 'fechaInicio', 'fechaFin'));
    }


    //Historial de Multas:
    public function historialMultas(Request $request)
    {
        /** @var \App\Models\User $usuario */
        $usuario = Auth::user();


        $fechaInicio = $request->input('fecha_inicio') . ' 00:00:00';
        $fechaFin = $request->input('fecha_fin') . ' 23:59:59';

        /** @var \App\Models\Cliente $cliente */
        $cliente = $usuario->obtenerCliente();


        if ($fechaInicio && $fechaFin) {
            $multas = $cliente->multas()
                ->select('id_multa', 'monto', 'fecha_hora', 'descripcion', 'estados_multa.nombre as nombre_estado')
                ->whereBetween('fecha_hora', [$fechaInicio, $fechaFin])
                ->orderBy('fecha_hora', 'desc')
                ->join('estados_multa', 'multas.id_estado', '=', 'estados_multa.id_estado')
                ->paginate(10);
            // $multas = DB::table('multas')
            //     ->select('multas.monto','multas.fecha_hora','multas.descripcion','estados_multa.nombre as estadoName')
            //     ->join('estados_multa','multas.id_estado', "=" , 'estados_multa.id_estado')
            //     ->where('multas.id_usuario', $cliente->id_usuario)
            //     ->whereBetween('multas.fecha_hora', [$fechaInicio, $fechaFin])
            //     ->whereIn('multas.id_estado', [1, 2])
            //     ->paginate(10); //Muestra los primeros 10 resultados 
        } else {
            $multas = [];
        }

        return view('cliente.historial_multas', compact('multas', 'fechaInicio', 'fechaFin'));
    }

    //Historial de Suspensiones:
    public function historialSuspensiones(Request $request)
    {
        /** @var \App\Models\User $usuario */
        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();

        $fechaInicio = $request->input('fecha_inicio') . ' 00:00:00';
        $fechaFin = $request->input('fecha_fin') . ' 23:59:59';

        if ($fechaInicio && $fechaFin) {
            $suspensiones = $cliente->suspensiones()->select('fecha_desde', 'fecha_hasta', 'descripcion', 'estados_suspension.nombre as nombre_estado')
                ->whereBetween('fecha_desde', [$fechaInicio, $fechaFin])
                ->orderBy('fecha_desde', 'desc')
                ->join('estados_suspension', 'suspensiones.id_estado', '=', 'estados_suspension.id_estado')
                ->paginate(10);

            // $suspensiones = DB::table('suspensiones')
            //     ->select('suspensiones.fecha_desde','suspensiones.fecha_hasta','suspensiones.fecha_hora','suspensiones.descripcion', 'estados_suspension.nombre as estado')
            //     ->join('estados_suspension','suspensiones.id_estado', "=" , 'estados_suspension.id_estado')
            //     ->where('suspensiones.id_usuario', $cliente->id_usuario)
            //     ->whereBetween('suspensiones.fecha_desde', [$fechaInicio, $fechaFin])
            //     ->whereIn('suspensiones.id_estado', [1, 2])
            //     ->paginate(10); //Muestra los primeros 10 resultados 
        } else {
            $suspensiones = [];
        }
        return view('cliente.historial_suspensiones', compact('suspensiones', 'fechaInicio', 'fechaFin'));
    }

    //Historial Movimientos:
    public function historialMovimientos(Request $request)
    {
        /** @var \App\Models\User $usuario */
        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();

        $movimientos = $cliente->historialesSaldo()->select('fecha_hora', 'monto', 'motivo')->orderBy('fecha_hora', 'desc')->paginate(10);

        return view('cliente.movimientos_saldo', compact('movimientos'));
    }
}
