<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Reserva;
use App\Models\Inspector;
use App\Models\Infraccion;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InfraccionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inspectores = Inspector::all();
        $reservas = Reserva::where('id_cliente_reservo', '<>', 3)->get();


        $this->crearReservasClientePrueba($inspectores);
        foreach ($reservas as $reserva) {
            if (rand(0, 1)) {
                $id_inspector = $inspectores->random()->id_usuario;
                $id_cliente = $reserva->clienteReservo->id_usuario;
                $fecha_hora = Carbon::parse($reserva->fecha_hora_retiro)->addMinutes(rand(10, 30));
                Infraccion::create([
                    'id_usuario_inspector' => $id_inspector,
                    'id_reserva' => $reserva->id_reserva,
                    'id_usuario_cliente' => $id_cliente,
                    'cantidad_puntos' => rand(-100, -10),
                    'fecha_hora' => $fecha_hora,
                    'motivo' => 'Mal uso de la bicicleta',
                ]);
            }
        }
    }

    private function crearReservasClientePrueba($inspectores) : void
    {
        $reservas_cliente_pueba = Reserva::where('id_cliente_reservo', 3)->where('id_estado', 3)->take(2)->get();
        $infracciones = [];
        foreach ($reservas_cliente_pueba as $reserva) {
            $id_usuario_inspector = $inspectores->random()->id_usuario;
            $id_usuario_cliente = $reserva->clienteReservo->id_usuario;
            $fecha_hora = Carbon::parse($reserva->fecha_hora_retiro)->addMinutes(rand(10, 30));
            $infracciones[] = [
                'id_usuario_inspector' => $id_usuario_inspector,
                'id_reserva' => $reserva->id_reserva,
                'id_usuario_cliente' => $id_usuario_cliente,
                'cantidad_puntos' => rand(-100, -10),
                'fecha_hora' => $fecha_hora,
                'motivo' => 'Mal uso de la bicicleta',
            ];
        }
        Infraccion::insert($infracciones);
    }
}
