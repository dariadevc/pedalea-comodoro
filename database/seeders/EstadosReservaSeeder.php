<?php

namespace Database\Seeders;

use App\Models\EstadoReserva;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadosReservaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            'Activa',
            'Alquilada', 
            'Finalizada',
            'Cancelada',
            'Modificada',
            'Reasignada',
        ];

        foreach ($estados as $estado) {
            EstadoReserva::create([
                'nombre' => $estado,
            ]);
        }
    }
}
