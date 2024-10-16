<?php

namespace Database\Seeders;

use App\Models\Bicicleta;
use App\Models\HistorialDanio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HistorialesDanioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bicicletas = Bicicleta::all();
        foreach ($bicicletas as $bicicleta) {
            $cantidad_historiales = rand(0, 5);


            for ($i = 0; $i < $cantidad_historiales; $i++) {
                HistorialDanio::create([
                    'id_bicicleta' => $bicicleta->id_bicicleta,
                ]);
            }
            // if (!empty($historiales)) {
            //     $bicicleta->historialesDanios()->saveMany($historiales);

        }
    }
}
