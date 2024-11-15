<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Reserva;
use App\Models\Cliente;
use App\Models\EstadoReserva;
use Illuminate\Console\Command;

class ChequeoReservasVencidas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:chequeo-reservas-vencidas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revisa las reservas alquiladas y descuenta puntos si no se devolvieron a tiempo';

    /**
     * Ejecuta el comando.
     *
     * @return void
     */
    public function handle()
    {
        $reservas = Reserva::whereIn('id_estado', [EstadoReserva::ALQUILADA, EstadoReserva::REASIGNADA])->get();

        foreach ($reservas as $reserva) {
            
            /** @var Reserva $reserva */
            if ($reserva->fecha_hora_devolucion->copy()->addHours(24)->isPast()) {
                $reserva->cerrarAlquiler();
            }
        }
    }
}

