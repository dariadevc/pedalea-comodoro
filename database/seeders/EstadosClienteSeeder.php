<?php

namespace Database\Seeders;

use App\Models\EstadoCliente;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EstadosClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            'Activo',
            'Suspendido',
        ];

        foreach ($estados as $estado) {
            EstadoCliente::create([
                'nombre' => $estado
            ]);
        }
    }
}
