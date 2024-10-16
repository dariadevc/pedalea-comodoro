<?php

namespace Database\Seeders;

use App\Models\Multa;
use App\Models\Cliente;
use App\Models\EstadoMulta;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MultasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->crearMultasClientePrueba();
        Multa::factory(50)->create();
    }

    private function crearMultasClientePrueba(): void
    {
        $estados_multa = EstadoMulta::all(); // [0] = Pendiente, [1] = Pagada
        $cliente_prueba = Cliente::find(3);
        $fecha_hora_multa_1 = new DateTime('2024-10-7 12:00:00');
        $fecha_hora_multa_2 = new DateTime('2024-10-10 17:30:00');
        $fecha_hora_multa_3 = new DateTime('2024-10-12 14:00:00');

        $multas = [
            [
                'id_usuario' => $cliente_prueba->id_usuario,
                'id_estado' => $estados_multa[1]->id_estado,
                'fecha_hora' => $fecha_hora_multa_1->format('Y-m-d H:i:s'),
                'monto' => 100,
                'descripcion' => 'Acumulacion de puntaje negativo',
            ],
            [
                'id_usuario' => $cliente_prueba->id_usuario,
                'id_estado' => $estados_multa[1]->id_estado,
                'fecha_hora' => $fecha_hora_multa_2->format('Y-m-d H:i:s'),
                'monto' => 100,
                'descripcion' => 'Acumulacion de puntaje negativo',
            ],
            [
                'id_usuario' => $cliente_prueba->id_usuario,
                'id_estado' => $estados_multa[0]->id_estado,
                'fecha_hora' => $fecha_hora_multa_3->format('Y-m-d H:i:s'),
                'monto' => 100,
                'descripcion' => 'Acumulacion de puntaje negativo',
            ],
        ];
        Multa::insert($multas);
    }
}
