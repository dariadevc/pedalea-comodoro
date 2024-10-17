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
        $estaciones = Estacion::where('id_estado', 1)->get();
        $estados_bicicleta = EstadoBicicleta::all();
        
        for ($i = 0; $i < 85; $i++) {
            $id_estacion = $estaciones->random()->id_estacion;
            $id_estado_bicicleta = $estados_bicicleta[0]->id_estado;
            Bicicleta::create([
                'id_estacion_actual' => $id_estacion,
                'id_estado' => $id_estado_bicicleta,
            ]);
            
        }

        for ($i = 0; $i < 15; $i++) {
            $id_estacion = $estaciones->random()->id_estacion;
            $id_estado_bicicleta = $estados_bicicleta[1]->id_estado;
            Bicicleta::create([
                'id_estacion_actual' => null,
                'id_estado' => $id_estado_bicicleta,
            ]);
            
        }
    }


}
