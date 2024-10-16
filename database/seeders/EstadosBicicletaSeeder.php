<?php

namespace Database\Seeders;

use App\Models\EstadoBicicleta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadosBicicletaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            'Disponible',
            'Deshabilitada',
        ];

        foreach ($estados as $estado) {
            EstadoBicicleta::create([
                'nombre' => $estado,
            ]);
        }
    }
}
