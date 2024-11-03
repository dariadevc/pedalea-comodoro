<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\HistorialSaldo;
use Carbon\Carbon;
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
            'motivo' => 'Cargar saldo',
            'monto' => 10000.00,
            'fecha_hora' => '2024-10-10 17:46:30',
        ]);
        $fechas_horas = [
            Carbon::parse('2024-10-15 12:55:00'),
            Carbon::parse('2024-10-20 10:05:00'),
            Carbon::parse('2024-10-23 21:05:00'),
        ];
        $montos = [10000.00, 10000.00, 7500.00];

        $reservas = $cliente->reservaReservo()->whereIn('id_estado', [3, 4])->get();
        foreach ($reservas as $reserva) {
            
            
            $fecha_hora_retiro = $reserva->fecha_hora_retiro;
            $fecha_hora_historial_saldo_senia = $fecha_hora_retiro->copy()->subMinutes(rand(1, 120));
            $senia = $reserva->senia;
            
            
            if (!empty($fechas_horas)) {
                if ($fechas_horas[0]->lessThan($fecha_hora_historial_saldo_senia)) {
                    $fecha_hora = array_shift($fechas_horas);
                    $monto = array_shift($montos);
                    $cliente->historialesSaldo()->create([
                        'motivo' => 'Cargar saldo',
                        'monto' => $monto,
                        'fecha_hora' => $fecha_hora,
                    ]);
                }
            }

            $cliente->historialesSaldo()->create([
                'motivo' => 'Pagar una reserva',
                'monto' => $senia * -1,
                'fecha_hora' => $fecha_hora_historial_saldo_senia,
            ]);


            if (!($reserva->id_estado == 4)) {
                if ($fecha_hora_historial_saldo_senia->between($fecha_hora_historial_saldo_senia->copy()->subMinutes(15), $fecha_hora_retiro)) {
                    $timestamp_inicio = $fecha_hora_historial_saldo_senia->copy()->timestamp;
                    $timestamp_fin = $fecha_hora_retiro->copy()->addMinutes(15)->timestamp;
                    $timestamp_aleatorio = mt_rand($timestamp_inicio, $timestamp_fin);
                    $fecha_hora_historial_saldo_monto = Carbon::createFromTimestamp($timestamp_aleatorio)->setTimezone('America/Argentina/Buenos_Aires');
                } else {
                    $timestamp_inicio = $fecha_hora_retiro->copy()->subMinutes(15);
                    $timestamp_fin = $fecha_hora_retiro->copy()->addMinutes(15);
                    $timestamp_aleatorio = mt_rand($timestamp_inicio, $timestamp_fin);
                    $fecha_hora_historial_saldo_monto = Carbon::createFromTimestamp($timestamp_aleatorio)->setTimezone('America/Argentina/Buenos_Aires');
                }
                $cliente->historialesSaldo()->create([
                    'motivo' => 'Pagar un alquiler',
                    'monto' => $reserva->calcularMontoRestante() * -1,
                    'fecha_hora' => $fecha_hora_historial_saldo_monto,
                ]);
            }
        }
    }
}
