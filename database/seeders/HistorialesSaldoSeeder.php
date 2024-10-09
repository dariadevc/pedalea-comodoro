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
        $cliente = Cliente::inRandomOrder()->first();
        HistorialSaldo::create([
            'id_usuario' => $cliente->id_usuario,
            'motivo' => 'Carga saldo',
            'monto' => 1000.00,
        ]);
        HistorialSaldo::create([
            'id_usuario' => $cliente->id_usuario,
            'motivo' => 'Pagar multa',
            'monto' => 100.00,
        ]);
        HistorialSaldo::create([
            'id_usuario' => $cliente->id_usuario,
            'motivo' => 'Pagar reserva',
            'monto' => 200.00,
        ]);
        HistorialSaldo::create([
            'id_usuario' => $cliente->id_usuario,
            'motivo' => 'Pagar alquiler',
            'monto' => 300.00,
        ]);
        
    }
}
