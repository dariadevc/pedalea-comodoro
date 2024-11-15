<?php

namespace Database\Seeders;

use App\Models\PuntajeDevolucion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PuntajesDevolucionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        PuntajeDevolucion::insert([
            [
                'tope_horario_entrega' => 0,
                'puntaje_sin_danio' => 5,
                'puntaje_con_danio_recuperable' => -40,
                'puntaje_con_danio_no_recuperable' => -80,
            ],
            [
                'tope_horario_entrega' => 12,
                'puntaje_sin_danio' => -5,
                'puntaje_con_danio_recuperable' => -60,
                'puntaje_con_danio_no_recuperable' => -120,
            ],
            [
                'tope_horario_entrega' => 24,
                'puntaje_sin_danio' => -50,
                'puntaje_con_danio_recuperable' => -90,
                'puntaje_con_danio_no_recuperable' => -180,
            ],
            [
                'tope_horario_entrega' => 999999,
                'puntaje_sin_danio' => -1000,
                'puntaje_con_danio_recuperable' => -1000,
                'puntaje_con_danio_no_recuperable' => -1000,
            ],
        ]);
    }
}
