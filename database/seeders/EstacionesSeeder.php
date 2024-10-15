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
            ['id_estado' => $id_estados_estacion[0], 'nombre' => 'Estacion 1', 'latitud' => 20.00000000, 'longitud' => 20.0000000, 'calificacion' => 0.00],
            ['id_estado' => $id_estados_estacion[0], 'nombre' => 'Estacion 2', 'latitud' => 20.00000000, 'longitud' => 20.0000000, 'calificacion' => 0.00],
            ['id_estado' => $id_estados_estacion[0], 'nombre' => 'Estacion 3', 'latitud' => 20.00000000, 'longitud' => 20.0000000, 'calificacion' => 0.00],
            ['id_estado' => $id_estados_estacion[0], 'nombre' => 'Estacion 4', 'latitud' => 20.00000000, 'longitud' => 20.0000000, 'calificacion' => 0.00],
            ['id_estado' => $id_estados_estacion[1], 'nombre' => 'Estacion 5', 'latitud' => 20.00000000, 'longitud' => 20.0000000, 'calificacion' => 0.00],
        ];

        Estacion::insert($estaciones);
    }
}
