<?php

namespace Database\Seeders;

use App\Models\Bicicleta;
use App\Models\Cliente;
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
        $clientePrueba = Cliente::find(3);
        $bicicletas = Bicicleta::all();
        $estaciones = Estacion::where('id_estado', 1)->get();
        $estados_reserva = EstadoReserva::all();

        // Crear reservas
        $this->crearReservasEspecificas($clientes, $estaciones, $estados_reserva);
        $this->crearReservasClientePrueba($clientes, $clientePrueba, $bicicletas, $estaciones, $estados_reserva);
    }

    private function crearReservasEspecificas($clientes, $estaciones, $estados_reserva): void
    {
        $reservas = [];
        $bicicletasOcupadas = [];

        // Estados de reservas específicos
        $this->generarReservasPorEstado($reservas, $clientes, $estaciones, $estados_reserva, 'Cancelada', 25, $bicicletasOcupadas);
        $this->generarReservasPorEstado($reservas, $clientes, $estaciones, $estados_reserva, 'Finalizada', 25, $bicicletasOcupadas);
        $this->generarReservasPorEstado($reservas, $clientes, $estaciones, $estados_reserva, 'Activa', 10, $bicicletasOcupadas);
        $this->generarReservasPorEstado($reservas, $clientes, $estaciones, $estados_reserva, 'Alquilada', 15, $bicicletasOcupadas);
        $this->generarReservasPorEstado($reservas, $clientes, $estaciones, $estados_reserva, 'Modificada', 5, $bicicletasOcupadas);
        $this->generarReservasPorEstado($reservas, $clientes, $estaciones, $estados_reserva, 'Reasignada', 10, $bicicletasOcupadas);

        Reserva::insert($reservas);
    }

    private function generarReservasPorEstado(&$reservas, $clientes, $estaciones, $estados_reserva, $estado, $cantidad, &$bicicletasOcupadas)
    {
        $estado_reserva = $estados_reserva->where('nombre', $estado)->first();
        for ($i = 0; $i < $cantidad; $i++) {

            $tiempo_uso = rand(1, 6);

            if (in_array($estado_reserva->nombre, ['Activa', 'Modificada'])) {
                $fechaHoraRetiro = Carbon::now()->addHours(rand(0, 2))->addMinutes(rand(0, 59))->addSeconds(rand(0, 59));
                $fechaHoraDevolucion = (clone $fechaHoraRetiro)->addHours($tiempo_uso);
            } elseif (in_array($estado_reserva->nombre, ['Alquilada', 'Reasignada'])) {

                $fechaHoraDevolucion = Carbon::now()->addHours(rand(0, 6))->addMinutes(rand(0, 59))->addSeconds(rand(0, 59));
                $fechaHoraRetiro = (clone $fechaHoraDevolucion)->subHours($tiempo_uso);
            } else {
                $fechaHoraRetiro = Carbon::now()->subYear()->addDays(rand(0, 365))->endOfDay()->subDays(1)->addHours(rand(0, 23))->addMinutes(rand(0, 59));
                $fechaHoraDevolucion = (clone $fechaHoraRetiro)->addHours($tiempo_uso);
            }

            $monto = $tiempo_uso * 1000;
            $senia = $monto * 0.25;

            // Seleccionar estación disponible
            $estacionRetiro = $estaciones->random();
            $estacionDevolucion = $estaciones->random();

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
                if (in_array($estado_reserva->nombre, ['Activa', 'Alquilada', 'Modificada', 'Reasignada'])) {
                    $bicicletasOcupadas[] = $bicicletaDisponible->id_bicicleta;
                }
            }

            // Puntaje obtenido si la reserva está finalizada
            $puntaje_obtenido = $estado_reserva->nombre == 'Finalizada' ? rand(-100, 50) : null;

            // ID del cliente que devuelve la bicicleta
            $id_cliente_devuelve = null;
            if (in_array($estado_reserva->nombre, ['Finalizada', 'Reasignada'])) {
                $id_cliente_devuelve = $clientes->random()->id_usuario;
            }

            // Crear la reserva
            $reservas[] = [
                'id_bicicleta' => $bicicletaDisponible->id_bicicleta,
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
    }

    private function crearReservasClientePrueba($clientes, $clientePrueba, $bicicletas, $estaciones, $estados_reserva): void
    {
        $reservas = [];
        $fechaInicio = Carbon::now()->subYear();

        $estados = ['Cancelada', 'Finalizada'];
        
        // Crear 25 reservas canceladas o modificadas para el cliente de prueba
        for ($i = 0; $i < 20; $i++) {
            // Generar fecha aleatoria
            $fechaHoraRetiro = Carbon::createFromTimestamp(rand($fechaInicio->timestamp, Carbon::now()->timestamp))
                ->setTime(rand(0, 23), rand(0, 59));
            $tiempo_uso = rand(1, 6);
            $fechaHoraDevolucion = (clone $fechaHoraRetiro)->addHours($tiempo_uso);

            $monto = $tiempo_uso * 1000;
            $senia = $monto * 0.25;


            // Seleccionar estado de reserva
            $estado_reserva = $estados_reserva->where('nombre', $estados[rand(0, 1)])->first();

            // Seleccionar bicicleta y estaciones
            $bicicleta = $bicicletas->random();
            $estacionRetiro = $estaciones->random();
            $estacionDevolucion = $estaciones->random();

            // Puntaje obtenido si la reserva está finalizada
            $puntaje_obtenido = $estado_reserva->nombre == 'Finalizada' ? rand(-100, 50) : null;

            $id_cliente_devuelve = rand(0, 1) ? $clientes->random()->id_usuario : null;


            $reservas[] = [
                'id_bicicleta' => $bicicleta->id_bicicleta,
                'id_estacion_retiro' => $estacionRetiro->id_estacion,
                'id_estacion_devolucion' => $estacionDevolucion->id_estacion,
                'id_estado' => $estado_reserva->id_estado,
                'id_cliente_reservo' => $clientePrueba->id_usuario,
                'id_cliente_devuelve' => $id_cliente_devuelve,
                'fecha_hora_retiro' => $fechaHoraRetiro,
                'fecha_hora_devolucion' => $fechaHoraDevolucion,
                'monto' => $monto,
                'senia' => $senia,
                'puntaje_obtenido' => $puntaje_obtenido,
            ];
        }

        // Insertar reservas en la base de datos
        Reserva::insert($reservas);
    }
}