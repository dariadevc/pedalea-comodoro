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


        $this->crearInfraccionesClientePrueba($inspectores);
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

    private function crearInfraccionesClientePrueba($inspectores): void
    {
        $reservas[] = Reserva::where('id_reserva', 37)->first();
        $reservas[] = Reserva::where('id_reserva', 38)->first();
        $infracciones = [];
        $motivos = [
            'Se le realizo una infracción por dañar la bicicleta.',
            'Se le realizo una infracción por estar haciendo maniobras peligrosas en la calle.',
        ];
        $puntos = [
            -25,
            -20,
        ];
        $fechas = [
            '2024-10-22 14:46:31',
            '2024-10-23 15:29:50',
        ];
        for ($i = 0; $i < 2; $i++) {
            $id_usuario_inspector = $inspectores->random()->id_usuario;
            $id_usuario_cliente = $reservas[$i]->id_cliente_reservo;
            $id_reserva = $reservas[$i]->id_reserva;
            $motivo = $motivos[$i];
            $cantidad_puntos = $puntos[$i];
            $fecha_hora = Carbon::parse($fechas[$i]);
            $infracciones[] = [
                'id_usuario_inspector' => $id_usuario_inspector,
                'id_reserva' => $id_reserva,
                'id_usuario_cliente' => $id_usuario_cliente,
                'cantidad_puntos' => $cantidad_puntos,
                'fecha_hora' => $fecha_hora,
                'motivo' => $motivo,
            ];
        }
        Infraccion::insert($infracciones);
    }
}
