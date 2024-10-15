<?php

namespace Database\Seeders;

use App\Models\TipoCalificacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TiposCalificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Son la cantidad de estrellas que puede tener una calificación
        $tipos_calificacion = [
            1,
            2,
            3,
            4,
            5,
        ];

        foreach ($tipos_calificacion as $cantidad_estrellas) {
            TipoCalificacion::create([
                'cantidad_estrellas' => $cantidad_estrellas,
            ]);
        }
    }
}
