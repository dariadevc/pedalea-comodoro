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

        for ($i = 0; $i < 25; $i++) {
            $fechaHoraRetiro = Carbon::createFromTimestamp(rand($fechaInicio->timestamp, Carbon::now()->timestamp))
                ->setTime(rand(0, 23), rand(0, 59));

            $tiempo_uso = rand(1, 6);
            $fechaHoraDevolucion = (clone $fechaHoraRetiro)->addHours($tiempo_uso);

            $monto = $tiempo_uso * 1000;
            $senia = $monto * 0.25;

            $estado_reserva = $estados_reserva->random();
            $puntaje_obtenido = $estado_reserva->nombre == 'Finalizada' ? rand(-100, 50) : null;

            $id_cliente_devuelve = rand(0, 1) ? $clientes->random()->id_usuario : null;

            $reservas[] = [
                'id_bicicleta' => $bicicletas->random()->id_bicicleta,
                'id_estacion_retiro' => $estaciones->random()->id_estacion,
                'id_estacion_devolucion' => $estaciones->random()->id_estacion,
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


    private function crearReservasClientePrueba($clientes, $bicicletas, $estaciones): void
    {

        $cliente_prueba = Cliente::find(3);

        $reservas = [];
        $fechaInicio = Carbon::now()->subYear();

        $estados_excluidos = ['Alquilada', 'Activa', 'Modificada', 'Reasignada'];
        $estados_reserva = EstadoReserva::whereNotIn('nombre', $estados_excluidos)->get();

        for ($i = 0; $i < 10; $i++) {

            $fechaHoraRetiro = Carbon::createFromTimestamp(rand($fechaInicio->timestamp, Carbon::now()->timestamp))
                ->setTime(rand(0, 23), rand(0, 59));

            $tiempo_uso = rand(1, 6);
            $fechaHoraDevolucion = (clone $fechaHoraRetiro)->addHours($tiempo_uso);

            $monto = $tiempo_uso * 1000;
            $senia = $monto * 0.25;

            $estado_reserva = $estados_reserva->random();
            $puntaje_obtenido = $estado_reserva->nombre == 'Finalizada' ? rand(-50, 50) : null;

            $id_cliente_devuelve = rand(0, 1) ? $clientes->random()->id_usuario : null;
            $id_cliente_devuelve = $estado_reserva->nombre == 'Finalizada' ? (rand(0, 1 ) ? $clientes->random()->id_usuario : null): null;


            $reservas[] = [
                'id_bicicleta' => $bicicletas->random()->id_bicicleta,
                'id_estacion_retiro' => $estaciones->random()->id_estacion,
                'id_estacion_devolucion' => $estaciones->random()->id_estacion,
                'id_estado' => $estado_reserva->id_estado,
                'id_cliente_reservo' => $cliente_prueba->id_usuario,
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
}
