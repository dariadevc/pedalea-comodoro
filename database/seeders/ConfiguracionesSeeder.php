<?php

namespace Database\Seeders;

use App\Models\Configuracion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfiguracionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $configuraciones = [
            [
                'clave' => 'tarifa',
                'valor' => '1000',
            ], [
                'clave' => 'fecha_modificacion_tarifa',
                'valor' => '2024-08-20',
            ],
        ];
        Configuracion::insert($configuraciones);
    }
}
