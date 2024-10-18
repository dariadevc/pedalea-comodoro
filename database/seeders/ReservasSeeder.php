<?php

namespace Database\Seeders;

use App\Models\Bicicleta;
use App\Models\Cliente;
use App\Models\Estacion;
use App\Models\EstadoReserva;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $clientes = Cliente::where('id_usuario', '<>', 3)->get();
        $bicicletas = Bicicleta::all();
        $estaciones = Estacion::all();
        $estados_reserva = EstadoReserva::all();


        $this->crearReservasAleatorias($clientes, $bicicletas, $estaciones, $estados_reserva);


        $this->crearReservasClientePrueba($clientes, $bicicletas, $estaciones);
    }

    private function crearReservasAleatorias($clientes, $bicicletas, $estaciones, $estados_reserva): void
    {
        $fechaInicio = Carbon::now()->subYear();
        $reservas = [];
        $bicicletasOcupadas = [];

        for ($i = 0; $i < 75; $i++) {
            $fechaHoraRetiro = Carbon::createFromTimestamp(rand($fechaInicio->timestamp, Carbon::now()->timestamp))
                ->setTime(rand(0, 23), rand(0, 59));

            $tiempo_uso = rand(1, 6);
            $fechaHoraDevolucion = (clone $fechaHoraRetiro)->addHours($tiempo_uso);

            $monto = $tiempo_uso * 1000;
            $senia = $monto * 0.25;

            $estado_reserva = $estados_reserva->random();
            $estadoNombre = $estado_reserva->nombre;

            // Seleccionar estación disponible
            $estacionRetiro = $estaciones->where('id_estado', 1)->random();
            $estacionDevolucion = $estaciones->where('id_estado', 1)->random();

            // Filtrar bicicletas disponibles en la estación de retiro
            $bicicletasFiltradas = Bicicleta::where('id_estado', 1)
                ->where('id_estacion_actual', $estacionRetiro->id_estacion)
                ->whereNotIn('id_bicicleta', $bicicletasOcupadas)
                ->get();

            // Asignar una bicicleta disponible o buscar en otras estaciones
            $bicicletaDisponible = null;
            if ($bicicletasFiltradas->isNotEmpty()) {
                $bicicletaDisponible = $bicicletasFiltradas->random();
            } else {
                // Si no hay bicicletas disponibles en la estación, buscar en otras estaciones
                $bicicletaDisponible = Bicicleta::where('id_estado', 1)
                    ->whereNotIn('id_bicicleta', $bicicletasOcupadas)
                    ->first(); // Asignar solo una bicicleta de cualquier estación
            }

            // Marcar la bicicleta como ocupada si el estado de la reserva es activo o similar
            if ($bicicletaDisponible) {
                if (in_array($estadoNombre, ['Activa', 'Alquilada', 'Modificada', 'Reasignada'])) {
                    $bicicletasOcupadas[] = $bicicletaDisponible->id_bicicleta;
                }
            }

            // Generar los demás datos de la reserva
            $puntaje_obtenido = $estado_reserva->nombre == 'Finalizada' ? rand(-100, 50) : null;
            $id_cliente_devuelve = null;

            if (in_array($estadoNombre, ['Finalizada', 'Reasignada'])) {
                $id_cliente_devuelve = rand(0, 1) ? $clientes->random()->id_usuario : null;
            } elseif ($estado_reserva->nombre == 'Reasignada') {
                $id_cliente_devuelve = $clientes->random()->id_usuario;
            }

            // Crear la reserva
            $reservas[] = [
                'id_bicicleta' => $bicicletaDisponible ? $bicicletaDisponible->id_bicicleta : null,
                'id_estacion_retiro' => $estacionRetiro->id_estacion,
                'id_estacion_devolucion' => $estacionDevolucion->id_estacion,
                'id_estado' => $estado_reserva->id_estado,
                'id_cliente_reservo' => $clientes->random()->id_usuario,
                'id_cliente_devuelve' => $id_cliente_devuelve,
                'fecha_hora_retiro' => $fechaHoraRetiro,
                'fecha_hora_devolucion' => $fechaHoraDevolucion,
                'monto' => $monto,
                'senia' => $senia,
                'puntaje_obtenido' => $puntaje_obtenido,
            ];
        }

        Reserva::insert($reservas);
    }



    // private function crearReservasAleatorias($clientes, $bicicletas, $estaciones, $estados_reserva): void
    // {

    //     $fechaInicio = Carbon::now()->subYear();

    //     $reservas = [];

    //     for ($i = 0; $i < 25; $i++) {
    //         $fechaHoraRetiro = Carbon::createFromTimestamp(rand($fechaInicio->timestamp, Carbon::now()->timestamp))
    //             ->setTime(rand(0, 23), rand(0, 59));

    //         $tiempo_uso = rand(1, 6);
    //         $fechaHoraDevolucion = (clone $fechaHoraRetiro)->addHours($tiempo_uso);

    //         $monto = $tiempo_uso * 1000;
    //         $senia = $monto * 0.25;

    //         $estado_reserva = $estados_reserva->random();
    //         $puntaje_obtenido = $estado_reserva->nombre == 'Finalizada' ? rand(-100, 50) : null;

    //         $id_cliente_devuelve = rand(0, 1) ? $clientes->random()->id_usuario : null;

    //         $reservas[] = [
    //             'id_bicicleta' => $bicicletas->random()->id_bicicleta,
    //             'id_estacion_retiro' => $estaciones->random()->id_estacion,
    //             'id_estacion_devolucion' => $estaciones->random()->id_estacion,
    //             'id_estado' => $estado_reserva->id_estado,
    //             'id_cliente_reservo' => $clientes->random()->id_usuario,
    //             'id_cliente_devuelve' => $id_cliente_devuelve,
    //             'fecha_hora_retiro' => $fechaHoraRetiro,
    //             'fecha_hora_devolucion' => $fechaHoraDevolucion,
    //             'monto' => $monto,
    //             'senia' => $senia,
    //             'puntaje_obtenido' => $puntaje_obtenido,
    //         ];
    //     }


    //     Reserva::insert($reservas);
    // }


    private function crearReservasClientePrueba($clientes, $bicicletas, $estaciones): void
    {
        // Encontrar al cliente de prueba
        $cliente_prueba = Cliente::find(3);
        $reservas = [];
        $fechaInicio = Carbon::now()->subYear();
        $estados_reserva = EstadoReserva::whereIn('nombre', ['Cancelada', 'Finalizada'])->get();

        for ($i = 0; $i < 15; $i++) {
            $fechaHoraRetiro = Carbon::createFromTimestamp(rand($fechaInicio->timestamp, Carbon::now()->timestamp))
                ->setTime(rand(0, 23), rand(0, 59));
            $tiempo_uso = rand(1, 6);
            $fechaHoraDevolucion = (clone $fechaHoraRetiro)->addHours($tiempo_uso);
            $monto = $tiempo_uso * 1000;
            $senia = $monto * 0.25;

            $estado_reserva = $estados_reserva->random();
            $puntaje_obtenido = $estado_reserva->nombre == 'Finalizada' ? rand(-50, 50) : null;

            // Asignar cualquier bicicleta y estación (sin importar si están deshabilitadas)
            $bicicleta = $bicicletas->random();
            $estacionRetiro = $estaciones->random();
            $estacionDevolucion = $estaciones->random();

            // Crear los datos de la reserva
            $reservas[] = [
                'id_bicicleta' => $bicicleta->id_bicicleta,
                'id_estacion_retiro' => $estacionRetiro->id_estacion,
                'id_estacion_devolucion' => $estacionDevolucion->id_estacion,
                'id_estado' => $estado_reserva->id_estado,
                'id_cliente_reservo' => $cliente_prueba->id_usuario,
                'id_cliente_devuelve' => null,  // Para este caso no se asigna un cliente que devuelve
                'fecha_hora_retiro' => $fechaHoraRetiro,
                'fecha_hora_devolucion' => $fechaHoraDevolucion,
                'monto' => $monto,
                'senia' => $senia,
                'puntaje_obtenido' => $puntaje_obtenido,
            ];
        }

        Reserva::insert($reservas);
    }


    // private function crearReservasClientePrueba($clientes, $bicicletas, $estaciones): void
    // {

    //     $cliente_prueba = Cliente::find(3);

    //     $reservas = [];
    //     $fechaInicio = Carbon::now()->subYear();

    //     $estados_excluidos = ['Alquilada', 'Activa', 'Modificada', 'Reasignada'];
    //     $estados_reserva = EstadoReserva::whereNotIn('nombre', $estados_excluidos)->get();

    //     for ($i = 0; $i < 10; $i++) {

    //         $fechaHoraRetiro = Carbon::createFromTimestamp(rand($fechaInicio->timestamp, Carbon::now()->timestamp))
    //             ->setTime(rand(0, 23), rand(0, 59));

    //         $tiempo_uso = rand(1, 6);
    //         $fechaHoraDevolucion = (clone $fechaHoraRetiro)->addHours($tiempo_uso);

    //         $monto = $tiempo_uso * 1000;
    //         $senia = $monto * 0.25;

    //         $estado_reserva = $estados_reserva->random();
    //         $puntaje_obtenido = $estado_reserva->nombre == 'Finalizada' ? rand(-50, 50) : null;

    //         $id_cliente_devuelve = rand(0, 1) ? $clientes->random()->id_usuario : null;
    //         $id_cliente_devuelve = $estado_reserva->nombre == 'Finalizada' ? (rand(0, 1 ) ? $clientes->random()->id_usuario : null): null;


    //         $reservas[] = [
    //             'id_bicicleta' => $bicicletas->random()->id_bicicleta,
    //             'id_estacion_retiro' => $estaciones->random()->id_estacion,
    //             'id_estacion_devolucion' => $estaciones->random()->id_estacion,
    //             'id_estado' => $estado_reserva->id_estado,
    //             'id_cliente_reservo' => $cliente_prueba->id_usuario,
    //             'id_cliente_devuelve' => $id_cliente_devuelve,
    //             'fecha_hora_retiro' => $fechaHoraRetiro,
    //             'fecha_hora_devolucion' => $fechaHoraDevolucion,
    //             'monto' => $monto,
    //             'senia' => $senia,
    //             'puntaje_obtenido' => $puntaje_obtenido,
    //         ];
    //     }


    //     Reserva::insert($reservas);
    // }
}
