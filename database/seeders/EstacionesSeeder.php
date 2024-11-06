<?php

namespace Database\Seeders;

use App\Models\Estacion;
use App\Models\EstadoEstacion;
use Illuminate\Database\Seeder;

class EstacionesSeeder extends Seeder
{
    public function run(): void
    {
        $id_estados_estacion = EstadoEstacion::pluck('id_estado')->toArray();

        $estaciones = [
            ['id_estado' => $id_estados_estacion[0], 'nombre' => 'Plaza España Centro', 'latitud' => -45.86266040236639, 'longitud' =>  -67.48228049016376, 'calificacion' => 0.00],
            ['id_estado' => $id_estados_estacion[0], 'nombre' => 'Plaza Pedro Km 3', 'latitud' => -45.83643985726673, 'longitud' => -67.47797093428925, 'calificacion' => 0.00],
            ['id_estado' => $id_estados_estacion[0], 'nombre' => 'Plaza La Nación', 'latitud' => -45.88056625088955, 'longitud' => -67.51940790448202, 'calificacion' => 0.00],
            ['id_estado' => $id_estados_estacion[0], 'nombre' => 'Plaza Las Torres', 'latitud' => -45.869836860442895, 'longitud' => -67.48965318683018, 'calificacion' => 0.00],
            ['id_estado' => $id_estados_estacion[1], 'nombre' => 'Plaza Carlos Gardel', 'latitud' => -45.86834954711604, 'longitud' => -67.50331437365104, 'calificacion' => 0.00],
        ];

        Estacion::insert($estaciones);
    }
}
