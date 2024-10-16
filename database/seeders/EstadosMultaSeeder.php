<?php

namespace Database\Seeders;

use App\Models\EstadoMulta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadosMultaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            ['nombre' => 'Pendiente'],
            ['nombre' => 'Pagada'],
        ];

        foreach ($estados as $estado) {
            EstadoMulta::create($estado);
        }
    }
}
