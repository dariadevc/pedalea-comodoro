<?php

namespace Database\Seeders;

use App\Models\Danio;
use App\Models\TipoDanio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DaniosSeeder extends Seeder
{

    public function run(): void
    {
        $id_tipos_danio = TipoDanio::pluck('id_tipo_danio')->toArray(); // 0 recuperable y 1 no recuperable

        $danios = [
            ['descripcion' => 'Cadena rota o floja', 'id_tipo_danio' => $id_tipos_danio[0]],
            ['descripcion' => 'Neumatico desinflado', 'id_tipo_danio' => $id_tipos_danio[0]],
            ['descripcion' => 'Asiento roto', 'id_tipo_danio' => $id_tipos_danio[0]],
            ['descripcion' => 'Manubrio torcido', 'id_tipo_danio' => $id_tipos_danio[0]],
            ['descripcion' => 'Pedales flojos', 'id_tipo_danio' => $id_tipos_danio[0]],
            ['descripcion' => 'Llanta doblada', 'id_tipo_danio' => $id_tipos_danio[1]],
            ['descripcion' => 'Cuadro abollado', 'id_tipo_danio' => $id_tipos_danio[1]],
            ['descripcion' => 'Desviador roto', 'id_tipo_danio' => $id_tipos_danio[1]],
        ];

        Danio::insert($danios);
    }
}
