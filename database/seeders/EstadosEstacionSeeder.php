<?php

namespace Database\Seeders;

use App\Models\EstadoEstacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadosEstacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            'Habilitada',
            'Deshabilitada',
        ];

        foreach ($estados as $estado) {
            EstadoEstacion::create([
                'nombre' => $estado,
            ]);
        }
    }
}
