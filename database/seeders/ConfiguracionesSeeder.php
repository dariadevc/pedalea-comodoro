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
                'valor' => '1000.00',
            ], [
                'clave' => 'ultima_fecha_modificacion_tarifa',
                'valor' => '2024-08-20',
            ], [
                'clave' => 'limite_multiplicador_negativo',
                'valor' => '3',
            ],
        ];
        Configuracion::insert($configuraciones);
    }
}
