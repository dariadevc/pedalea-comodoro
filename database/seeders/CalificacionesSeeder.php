<?php

namespace Database\Seeders;

use App\Models\Calificacion;
use App\Models\Estacion;
use App\Models\TipoCalificacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CalificacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estaciones = Estacion::all();
        $tipos_calificacion = TipoCalificacion::all();

        for ($i = 0; $i < 500; $i++) {
            Calificacion::create([
                'id_estacion' => $estaciones->random()->id_estacion,
                'id_tipo_calificacion' => $tipos_calificacion->random()->id_tipo_calificacion,
            ]);
        }
    }
}
