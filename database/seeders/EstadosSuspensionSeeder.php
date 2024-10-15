<?php

namespace Database\Seeders;

use App\Models\EstadoSuspension;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadosSuspensionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            ['nombre' => 'Activa'],
            ['nombre' => 'Finalizada'],
        ];

        foreach ($estados as $estado) {
            EstadoSuspension::create($estado);
        }
    }
}
