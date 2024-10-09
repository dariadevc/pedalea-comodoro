<?php

namespace Database\Seeders;

use App\Models\RangoPuntos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RangosPuntosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Rangos puntos
        $rangos = [
            [
                'rango_minimo' => -1,
                'rango_maximo' => -200,
                'monto_multa' => 100,
                'tiempo_suspension_dias' => null
            ],
            [
                'rango_minimo' => -201,
                'rango_maximo' => -500,
                'monto_multa' => 500,
                'tiempo_suspension_dias' => null
            ],
            [
                'rango_minimo' => -201,
                'rango_maximo' => -500,
                'monto_multa' => 1000,
                'tiempo_suspension_dias' => 90
            ],
            [
                'rango_minimo' => -501,
                'rango_maximo' => -1000,
                'monto_multa' => 1500,
                'tiempo_suspension_dias' => 180
            ],
            [
                'rango_minimo' => -1001,
                'rango_maximo' => -999999,
                'monto_multa' => 1500,
                'tiempo_suspension_dias' => 1095
            ]
        ];

        foreach ($rangos as $rango) {
            RangoPuntos::create($rango);
        }
    }
}
