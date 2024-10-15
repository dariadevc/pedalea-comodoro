<?php

namespace Database\Seeders;

use App\Models\Bicicleta;
use App\Models\Estacion;
use App\Models\EstadoBicicleta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class BicicletasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estaciones = Estacion::all();
        $estados_bicicleta = EstadoBicicleta::all();

        for ($i = 0; $i < 100; $i++) {
            $id_estacion = $estaciones->random()->id_estacion;
            $id_estado_bicicleta = $estados_bicicleta->random()->id_estado;
            Bicicleta::create([
                'id_estacion_actual' => ($id_estado_bicicleta === 2) ? null : $id_estacion, // Asignar null si el estado es 2
                'id_estado' => $id_estado_bicicleta,
            ]);
            
        }
    }


}
