<?php

namespace Database\Seeders;

use App\Models\TipoDanio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TiposDanioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos_danio = [
            'Daño recuperable',
            'Daño no recuperable',
        ];

        foreach ($tipos_danio as $tipo_danio) {
            TipoDanio::create([
                'descripcion' => $tipo_danio,
            ]);
        }
    }
}
