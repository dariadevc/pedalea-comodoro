<?php

namespace Database\Seeders;

use App\Models\Bicicleta;
use App\Models\Cliente;
use App\Models\Configuracion;
use App\Models\Estacion;
use App\Models\EstadoReserva;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ReservasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientes = Cliente::where('id_usuario', '<>', 3)->get();
        $clientesDevolucion = Cliente::where('id_usuario', '<>', 3)->get();
        $clientePrueba = Cliente::find(3);
        $tarifa = Configuracion::where('clave', 'tarifa')->first();


        $fecha_hora_inicio_activa_modificada = Carbon::now();
        $fecha_hora_fin_activa_modificada = Carbon::now()->addHours(2);

        $fecha_hora_inicio_alquilada_reasignada = Carbon::now()->subHours(2);
        $fecha_hora_fin_alquilada_reasignada = Carbon::now();

        /**
         * RESERVAS PARA LA ESTACION 1
         */
        $timestampAleatorio = rand($fecha_hora_inicio_activa_modificada->timestamp, $fecha_hora_fin_activa_modificada->timestamp);
        $fechaHoraAleatoria = Carbon::createFromTimestamp($timestampAleatorio, 'America/Argentina/Buenos_Aires');
        Reserva::create([
            'id_bicicleta' => 1,
            'id_estacion_retiro' => 1,
            'id_estacion_devolucion' => 1,
            'id_estado' => 1,
            'id_cliente_reservo' => $clientes->shift()->id_usuario,
            'id_cliente_devuelve' => null,
            'fecha_hora_retiro' => $fechaHoraAleatoria,
            'fecha_hora_devolucion' => (clone $fechaHoraAleatoria)->addHours(3),
            'monto' => $tarifa->valor * 3,
            'senia' => ($tarifa->valor * 3) * 0.25,
            'puntaje_obtenido' => null,
        ]);

        $timestampAleatorio = rand($fecha_hora_inicio_activa_modificada->timestamp, $fecha_hora_fin_activa_modificada->timestamp);
        $fechaHoraAleatoria = Carbon::createFromTimestamp($timestampAleatorio, 'America/Argentina/Buenos_Aires');
        Reserva::create([
            'id_bicicleta' => 2,
            'id_estacion_retiro' => 1,
            'id_estacion_devolucion' => 3,
            'id_estado' => 1,
            'id_cliente_reservo' => $clientes->shift()->id_usuario,
            'id_cliente_devuelve' => null,
            'fecha_hora_retiro' => $fechaHoraAleatoria,
            'fecha_hora_devolucion' => (clone $fechaHoraAleatoria)->addHours(5),
            'monto' => $tarifa->valor * 5,
            'senia' => ($tarifa->valor * 5) * 0.25,
            'puntaje_obtenido' => null,
        ]);

        $timestampAleatorio = rand($fecha_hora_inicio_alquilada_reasignada->timestamp, $fecha_hora_fin_alquilada_reasignada->timestamp);
        $fechaHoraAleatoria = Carbon::createFromTimestamp($timestampAleatorio, 'America/Argentina/Buenos_Aires');
        Reserva::create([
            'id_bicicleta' => 3,
            'id_estacion_retiro' => 2,
            'id_estacion_devolucion' => 1,
            'id_estado' => 2,
            'id_cliente_reservo' => $clientes->shift()->id_usuario,
            'id_cliente_devuelve' => null,
            'fecha_hora_retiro' => $fechaHoraAleatoria,
            'fecha_hora_devolucion' => (clone $fechaHoraAleatoria)->addHours(3),
            'monto' => $tarifa->valor * 3,
            'senia' => ($tarifa->valor * 3) * 0.25,
            'puntaje_obtenido' => null,
        ]);

        $timestampAleatorio = rand($fecha_hora_inicio_activa_modificada->timestamp, $fecha_hora_fin_activa_modificada->timestamp);
        $fechaHoraAleatoria = Carbon::createFromTimestamp($timestampAleatorio, 'America/Argentina/Buenos_Aires');
        Reserva::create([
            'id_bicicleta' => 4,
            'id_estacion_retiro' => 1,
            'id_estacion_devolucion' => 4,
            'id_estado' => 1,
            'id_cliente_reservo' => $clientes->shift()->id_usuario,
            'id_cliente_devuelve' => null,
            'fecha_hora_retiro' => $fechaHoraAleatoria,
            'fecha_hora_devolucion' => (clone $fechaHoraAleatoria)->addHours(1),
            'monto' => $tarifa->valor * 1,
            'senia' => ($tarifa->valor * 1) * 0.25,
            'puntaje_obtenido' => null,
        ]);

        $timestampAleatorio = rand($fecha_hora_inicio_activa_modificada->timestamp, $fecha_hora_fin_activa_modificada->timestamp);
        $fechaHoraAleatoria = Carbon::createFromTimestamp($timestampAleatorio, 'America/Argentina/Buenos_Aires');
        Reserva::create([
            'id_bicicleta' => 5,
            'id_estacion_retiro' => 1,
            'id_estacion_devolucion' => 1,
            'id_estado' => 1,
            'id_cliente_reservo' => $clientes->shift()->id_usuario,
            'id_cliente_devuelve' => null,
            'fecha_hora_retiro' => $fechaHoraAleatoria,
            'fecha_hora_devolucion' => (clone $fechaHoraAleatoria)->addHours(2),
            'monto' => $tarifa->valor * 2,
            'senia' => ($tarifa->valor * 2) * 0.25,
            'puntaje_obtenido' => null,
        ]);

        /**
         * RESERVAS PARA LA ESTACION 2
         */
        $timestampAleatorio = rand($fecha_hora_inicio_activa_modificada->timestamp, $fecha_hora_fin_activa_modificada->timestamp);
        $fechaHoraAleatoria = Carbon::createFromTimestamp($timestampAleatorio, 'America/Argentina/Buenos_Aires');
        Reserva::create([
            'id_bicicleta' => 6,
            'id_estacion_retiro' => 2,
            'id_estacion_devolucion' => 1,
            'id_estado' => 1,
            'id_cliente_reservo' => $clientes->shift()->id_usuario,
            'id_cliente_devuelve' => null,
            'fecha_hora_retiro' => $fechaHoraAleatoria,
            'fecha_hora_devolucion' => (clone $fechaHoraAleatoria)->addHours(4),
            'monto' => $tarifa->valor * 4,
            'senia' => ($tarifa->valor * 4) * 0.25,
            'puntaje_obtenido' => null,
        ]);

        $timestampAleatorio = rand($fecha_hora_inicio_alquilada_reasignada->timestamp, $fecha_hora_fin_alquilada_reasignada->timestamp);
        $fechaHoraAleatoria = Carbon::createFromTimestamp($timestampAleatorio, 'America/Argentina/Buenos_Aires');
        Reserva::create([
            'id_bicicleta' => 7,
            'id_estacion_retiro' => 1,
            'id_estacion_devolucion' => 2,
            'id_estado' => 6,
            'id_cliente_reservo' => $clientes->shift()->id_usuario,
            'id_cliente_devuelve' => $clientesDevolucion->shift()->id_usuario,
            'fecha_hora_retiro' => $fechaHoraAleatoria,
            'fecha_hora_devolucion' => (clone $fechaHoraAleatoria)->addHours(2),
            'monto' => $tarifa->valor * 2,
            'senia' => ($tarifa->valor * 2) * 0.25,
            'puntaje_obtenido' => null,
        ]);

        $timestampAleatorio = rand($fecha_hora_inicio_activa_modificada->timestamp, $fecha_hora_fin_activa_modificada->timestamp);
        $fechaHoraAleatoria = Carbon::createFromTimestamp($timestampAleatorio, 'America/Argentina/Buenos_Aires');
        Reserva::create([
            'id_bicicleta' => 8,
            'id_estacion_retiro' => 2,
            'id_estacion_devolucion' => 1,
            'id_estado' => 5,
            'id_cliente_reservo' => $clientes->shift()->id_usuario,
            'id_cliente_devuelve' => null,
            'fecha_hora_retiro' => $fechaHoraAleatoria,
            'fecha_hora_devolucion' => (clone $fechaHoraAleatoria)->addHours(1),
            'monto' => $tarifa->valor * 1,
            'senia' => ($tarifa->valor * 1) * 0.25,
            'puntaje_obtenido' => null,
        ]);

        /**
         * RESERVAS PARA LA ESTACION 3
         */

        $timestampAleatorio = rand($fecha_hora_inicio_activa_modificada->timestamp, $fecha_hora_fin_activa_modificada->timestamp);
        $fechaHoraAleatoria = Carbon::createFromTimestamp($timestampAleatorio, 'America/Argentina/Buenos_Aires');
        Reserva::create([
            'id_bicicleta' => 11,
            'id_estacion_retiro' => 3,
            'id_estacion_devolucion' => 3,
            'id_estado' => 1,
            'id_cliente_reservo' => $clientes->shift()->id_usuario,
            'id_cliente_devuelve' => null,
            'fecha_hora_retiro' => $fechaHoraAleatoria,
            'fecha_hora_devolucion' => (clone $fechaHoraAleatoria)->addHours(2),
            'monto' => $tarifa->valor * 2,
            'senia' => ($tarifa->valor * 2) * 0.25,
            'puntaje_obtenido' => null,
        ]);

        $timestampAleatorio = rand($fecha_hora_inicio_alquilada_reasignada->timestamp, $fecha_hora_fin_alquilada_reasignada->timestamp);
        $fechaHoraAleatoria = Carbon::createFromTimestamp($timestampAleatorio, 'America/Argentina/Buenos_Aires');
        Reserva::create([
            'id_bicicleta' => 12,
            'id_estacion_retiro' => 1,
            'id_estacion_devolucion' => 3,
            'id_estado' => 2,
            'id_cliente_reservo' => $clientes->shift()->id_usuario,
            'id_cliente_devuelve' => null,
            'fecha_hora_retiro' => $fechaHoraAleatoria,
            'fecha_hora_devolucion' => (clone $fechaHoraAleatoria)->addHours(3),
            'monto' => $tarifa->valor * 3,
            'senia' => ($tarifa->valor * 3) * 0.25,
            'puntaje_obtenido' => null,
        ]);

        $timestampAleatorio = rand($fecha_hora_inicio_activa_modificada->timestamp, $fecha_hora_fin_activa_modificada->timestamp);
        $fechaHoraAleatoria = Carbon::createFromTimestamp($timestampAleatorio, 'America/Argentina/Buenos_Aires');
        Reserva::create([
            'id_bicicleta' => 13,
            'id_estacion_retiro' => 3,
            'id_estacion_devolucion' => 4,
            'id_estado' => 5,
            'id_cliente_reservo' => $clientes->shift()->id_usuario,
            'id_cliente_devuelve' => null,
            'fecha_hora_retiro' => $fechaHoraAleatoria,
            'fecha_hora_devolucion' => (clone $fechaHoraAleatoria)->addHours(2),
            'monto' => $tarifa->valor * 2,
            'senia' => ($tarifa->valor * 2) * 0.25,
            'puntaje_obtenido' => null,
        ]);

        $timestampAleatorio = rand($fecha_hora_inicio_alquilada_reasignada->timestamp, $fecha_hora_fin_alquilada_reasignada->timestamp);
        $fechaHoraAleatoria = Carbon::createFromTimestamp($timestampAleatorio, 'America/Argentina/Buenos_Aires');
        Reserva::create([
            'id_bicicleta' => 15,
            'id_estacion_retiro' => 2,
            'id_estacion_devolucion' => 3,
            'id_estado' => 6,
            'id_cliente_reservo' => $clientes->shift()->id_usuario,
            'id_cliente_devuelve' => $clientesDevolucion->shift()->id_usuario,
            'fecha_hora_retiro' => $fechaHoraAleatoria,
            'fecha_hora_devolucion' => (clone $fechaHoraAleatoria)->addHours(2),
            'monto' => $tarifa->valor * 2,
            'senia' => ($tarifa->valor * 2) * 0.25,
            'puntaje_obtenido' => null,
        ]);

        /**
         * RESERVAS PARA LA ESTACION 4
         */

        $timestampAleatorio = rand($fecha_hora_inicio_activa_modificada->timestamp, $fecha_hora_fin_activa_modificada->timestamp);
        $fechaHoraAleatoria = Carbon::createFromTimestamp($timestampAleatorio, 'America/Argentina/Buenos_Aires');
        Reserva::create([
            'id_bicicleta' => 17,
            'id_estacion_retiro' => 4,
            'id_estacion_devolucion' => 4,
            'id_estado' => 5,
            'id_cliente_reservo' => $clientes->shift()->id_usuario,
            'id_cliente_devuelve' => null,
            'fecha_hora_retiro' => $fechaHoraAleatoria,
            'fecha_hora_devolucion' => (clone $fechaHoraAleatoria)->addHours(5),
            'monto' => $tarifa->valor * 5,
            'senia' => ($tarifa->valor * 5) * 0.25,
            'puntaje_obtenido' => null,
        ]);

        $timestampAleatorio = rand($fecha_hora_inicio_alquilada_reasignada->timestamp, $fecha_hora_fin_alquilada_reasignada->timestamp);
        $fechaHoraAleatoria = Carbon::createFromTimestamp($timestampAleatorio, 'America/Argentina/Buenos_Aires');
        Reserva::create([
            'id_bicicleta' => 19,
            'id_estacion_retiro' => 1,
            'id_estacion_devolucion' => 4,
            'id_estado' => 2,
            'id_cliente_reservo' => $clientes->shift()->id_usuario,
            'id_cliente_devuelve' => null,
            'fecha_hora_retiro' => $fechaHoraAleatoria,
            'fecha_hora_devolucion' => (clone $fechaHoraAleatoria)->addHours(4),
            'monto' => $tarifa->valor * 4,
            'senia' => ($tarifa->valor * 4) * 0.25,
            'puntaje_obtenido' => null,
        ]);



        $fecha_hora_inicio_cancelada_finalizada = Carbon::now()->subMonths(1);
        $fecha_hora_fin_cancelada_finalizada = Carbon::now()->subDays(1);

        for ($i = 0; $i < 5; $i++) { // Genera 5 reservas para el estado 3
            $timestampAleatorio = rand($fecha_hora_inicio_cancelada_finalizada->timestamp, $fecha_hora_fin_cancelada_finalizada->timestamp);
            $fechaHoraAleatoria = Carbon::createFromTimestamp($timestampAleatorio, 'America/Argentina/Buenos_Aires');
            $tiempo_uso = rand(1, 6);

            Reserva::create([
                'id_bicicleta' => rand(1, 20), // Asumiendo que tienes bicicletas numeradas del 1 al 20
                'id_estacion_retiro' => rand(1, 4), // Asumiendo que tienes 4 estaciones
                'id_estacion_devolucion' => rand(1, 4), // También las estaciones para la devolución
                'id_estado' => 3,
                'id_cliente_reservo' => $clientes->random()->id_usuario,
                'id_cliente_devuelve' => null,
                'fecha_hora_retiro' => $fechaHoraAleatoria,
                'fecha_hora_devolucion' => (clone $fechaHoraAleatoria)->addHours($tiempo_uso),
                'monto' => $tarifa->valor * $tiempo_uso,
                'senia' => ($tarifa->valor * $tiempo_uso) * 0.25,
                'puntaje_obtenido' => rand(1, 100),
            ]);
        }
        for ($i = 0; $i < 5; $i++) {
            $timestampAleatorio = rand($fecha_hora_inicio_cancelada_finalizada->timestamp, $fecha_hora_fin_cancelada_finalizada->timestamp);
            $fechaHoraAleatoria = Carbon::createFromTimestamp($timestampAleatorio, 'America/Argentina/Buenos_Aires');
            $tiempo_uso = rand(1, 6);
            Reserva::create([
                'id_bicicleta' => rand(1, 20),
                'id_estacion_retiro' => rand(1, 4),
                'id_estacion_devolucion' => rand(1, 4),
                'id_estado' => 3,
                'id_cliente_reservo' => $clientes->random()->id_usuario,
                'id_cliente_devuelve' => $clientes->random()->id_usuario,
                'fecha_hora_retiro' => $fechaHoraAleatoria,
                'fecha_hora_devolucion' => (clone $fechaHoraAleatoria)->addHours($tiempo_uso),
                'monto' => $tarifa->valor * $tiempo_uso,
                'senia' => ($tarifa->valor * $tiempo_uso) * 0.25,
                'puntaje_obtenido' => rand(1, 100),
            ]);
        }
        for ($i = 0; $i < 10; $i++) {
            $timestampAleatorio = rand($fecha_hora_inicio_cancelada_finalizada->timestamp, $fecha_hora_fin_cancelada_finalizada->timestamp);
            $fechaHoraAleatoria = Carbon::createFromTimestamp($timestampAleatorio, 'America/Argentina/Buenos_Aires');
            $tiempo_uso = rand(1, 6);
            Reserva::create([
                'id_bicicleta' => rand(1, 20),
                'id_estacion_retiro' => rand(1, 4),
                'id_estacion_devolucion' => rand(1, 4),
                'id_estado' => 4,
                'id_cliente_reservo' => $clientes->random()->id_usuario,
                'id_cliente_devuelve' => null,
                'fecha_hora_retiro' => $fechaHoraAleatoria,
                'fecha_hora_devolucion' => (clone $fechaHoraAleatoria)->addHours($tiempo_uso),
                'monto' => $tarifa->valor * $tiempo_uso,
                'senia' => ($tarifa->valor * $tiempo_uso) * 0.25,
                'puntaje_obtenido' => null,
            ]);
        }

        /**
         * UNA RESERVA ACTIVA PARA EL CLIENTE DE PRUEBA
         * Si no quieren la reserva activa comenten esta parte
         */
        // $tiempo_uso = 3;
        // Reserva::create([
        //     'id_bicicleta' => 20,
        //     'id_estacion_retiro' => 4,
        //     'id_estacion_devolucion' => 4,
        //     'id_estado' => 1,
        //     'id_cliente_reservo' => $clientePrueba->id_usuario,
        //     'id_cliente_devuelve' => null,
        //     'fecha_hora_retiro' => Carbon::now(),
        //     'fecha_hora_devolucion' => Carbon::now()->addHours($tiempo_uso),
        //     'monto' => $tarifa->valor * $tiempo_uso,
        //     'senia' => ($tarifa->valor * $tiempo_uso) * 0.25,
        //     'puntaje_obtenido' => null,
        // ]);
    }
}
