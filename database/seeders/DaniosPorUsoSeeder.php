<?php

namespace Database\Seeders;

use App\Models\Danio;
use App\Models\DanioPorUso;
use App\Models\HistorialDanio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DaniosPorUsoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $historiales_danio = HistorialDanio::all();
        $danios = Danio::all();
        $danios_por_uso = [];

        foreach ($historiales_danio as $historial_danio) {
            $danios_bicicleta = $danios->random(rand(1, $danios->count()));
            foreach ($danios_bicicleta as $danio_bicicleta) {
                $danios_por_uso[] = [
                    'id_bicicleta' => $historial_danio->bicicleta->id_bicicleta,
                    'id_historial_danio' => $historial_danio->id_historial_danio,
                    'id_danio' => $danio_bicicleta->id_danio,
                ];
            }
        }

        DanioPorUso::insert($danios_por_uso);
    }
}
