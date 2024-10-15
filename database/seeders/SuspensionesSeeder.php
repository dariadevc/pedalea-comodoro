<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\EstadoSuspension;
use App\Models\Suspension;
use DateTime;
use Illuminate\Database\Seeder;

class SuspensionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->crearSuspensionesParaClientePrueba();
        Suspension::factory(50)->create();
    }

    private function crearSuspensionesParaClientePrueba(): void
    {
        $estados_suspension = EstadoSuspension::all(); // [0] = Activa, [1] = Finalizada
        $cliente_prueba = Cliente::find(3);
        

        $fecha_hora_suspension_1 = new DateTime('2024-04-10 17:30:00');
        $fecha_hora_suspension_2 = new DateTime('2024-08-01 14:00:00');

        $suspensiones = [
            [
                'id_usuario' => $cliente_prueba->id_usuario,
                'id_estado' => $estados_suspension[1]->id_estado,
                'fecha_hora' => $fecha_hora_suspension_1->format('Y-m-d H:i:s'),
                'fecha_desde' => '2024-04-10',
                'fecha_hasta' => '2024-07-10',
                'descripcion' => 'Acumulación de puntaje negativo',
            ],
            [
                'id_usuario' => $cliente_prueba->id_usuario,
                'id_estado' => $estados_suspension[1]->id_estado,
                'fecha_hora' => $fecha_hora_suspension_2->format('Y-m-d H:i:s'),
                'fecha_desde' => '2024-08-01',
                'fecha_hasta' => '2024-09-01',
                'descripcion' => 'Acumulación de puntaje negativo',
            ],
        ];

        Suspension::insert($suspensiones);
    }
}
