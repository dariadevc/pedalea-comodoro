<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Reserva;
use App\Models\Cliente;
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
        $puntosADescontar = 5;

        $reservas = Reserva::where('id_estado', 2)->get();

        foreach ($reservas as $reserva) {
            $horaDevolucion = Carbon::parse($reserva->fecha_hora_devolucion);

            
            if ($horaDevolucion->addHours(24)->isPast()) {
                $cliente = Cliente::find($reserva->id_cliente_reservo);
                $cliente->puntaje -= $puntosADescontar;
                $cliente->save();

                $reserva->id_estado = 3;
                $reserva->save();
            }
        }
    }
}

