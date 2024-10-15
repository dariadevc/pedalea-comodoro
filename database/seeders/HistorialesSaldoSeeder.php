<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\HistorialSaldo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class HistorialesSaldoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->crearHistorialSaldoClientePrueba();

        $cliente = Cliente::inRandomOrder()->first();
        $cliente->historialesSaldo()->create([
            'motivo' => 'Carga saldo',
            'monto' => 1000.00,
        ]);
        $cliente->historialesSaldo()->create([
            'motivo' => 'Pagar multa',
            'monto' => 100.00,
        ]);
        $cliente->historialesSaldo()->create([
            'motivo' => 'Pagar reserva',
            'monto' => 200.00,
        ]);
        $cliente->historialesSaldo()->create([
            'motivo' => 'Pagar alquiler',
            'monto' => 300.00,
        ]);
    }

    private function crearHistorialSaldoClientePrueba()
    {
        $cliente = Cliente::find(3);

        $cliente->historialesSaldo()->create([
            'motivo' => 'Carga saldo',
            'monto' => 500.00,
        ]);

        $cliente->historialesSaldo()->create([
            'motivo' => 'Carga saldo',
            'monto' => 500.00,
        ]);
    }
}
