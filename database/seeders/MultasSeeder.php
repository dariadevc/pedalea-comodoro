<?php

namespace Database\Seeders;

use App\Models\Multa;
use App\Models\Cliente;
use App\Models\EstadoMulta;
use Carbon\Carbon;
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
        $fecha_hora_multa_1 = Carbon::parse('2024-10-17 15:00:43');
        $fecha_hora_multa_2 = Carbon::parse('2024-10-18 15:49:55');
        $fecha_hora_multa_3 = Carbon::parse('2024-10-20 18:10:00');
        $fecha_hora_multa_5 = Carbon::parse('2024-10-22 14:46:41');
        $fecha_hora_multa_6 = Carbon::parse('2024-10-23 15:30:00');
        $fecha_hora_multa_4 = Carbon::parse('2024-10-25 18:10:00');

        $multas = [
            [
                'id_usuario' => $cliente_prueba->id_usuario,
                'id_estado' => $estados_multa[1]->id_estado,
                'fecha_hora' => $fecha_hora_multa_1,
                'monto' => 100,
                'descripcion' => 'Multa generada por puntaje negativo acumulado: -35',
            ],
            [
                'id_usuario' => $cliente_prueba->id_usuario,
                'id_estado' => $estados_multa[1]->id_estado,
                'fecha_hora' => $fecha_hora_multa_2,
                'monto' => 200,
                'descripcion' => 'Multa generada por puntaje negativo acumulado: -40',
            ],
            [
                'id_usuario' => $cliente_prueba->id_usuario,
                'id_estado' => $estados_multa[0]->id_estado,
                'fecha_hora' => $fecha_hora_multa_3,
                'monto' => 300,
                'descripcion' => 'Multa generada por puntaje negativo acumulado: -95',
            ],
            [
                'id_usuario' => $cliente_prueba->id_usuario,
                'id_estado' => $estados_multa[0]->id_estado,
                'fecha_hora' => $fecha_hora_multa_5,
                'monto' => 500,
                'descripcion' => 'Multa generada por puntaje negativo acumulado: -115',
            ],
            [
                'id_usuario' => $cliente_prueba->id_usuario,
                'id_estado' => $estados_multa[0]->id_estado,
                'fecha_hora' => $fecha_hora_multa_6,
                'monto' => 600,
                'descripcion' => 'Multa generada por puntaje negativo acumulado: -130',
            ],
            [
                'id_usuario' => $cliente_prueba->id_usuario,
                'id_estado' => $estados_multa[0]->id_estado,
                'fecha_hora' => $fecha_hora_multa_4,
                'monto' => 700,
                'descripcion' => 'Multa generada por puntaje negativo acumulado: -125',
            ],
        ];
        Multa::insert($multas);
    }
}
