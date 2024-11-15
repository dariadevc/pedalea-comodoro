<?php

namespace App\Console\Commands;

use App\Models\Cliente;
use App\Models\Multa;
use App\Models\Suspension;
use App\Notifications\CambioPuntajeNotification;
use Illuminate\Support\Facades\Session;
use Illuminate\Console\Command;

class PremiarBuenaConducta extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:premiar-buena-conducta';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revisa cada 6 meses si no recibieron ni multas ni suspensiones, si es asi, se le otorgan puntos';

    /**
     * Execute the console command.
     */
    public function handle()
{
    $clientes = Cliente::all();

    foreach ($clientes as $cliente) {
        // Verificar si el cliente no tiene multas ni suspensiones en los últimos seis meses
        $sinMultas = Multa::where('id_usuario', $cliente->id_usuario)
            ->where('fecha_hora', '>=', now()->subMonths(6))
            ->count() == 0;
        $sinSuspensiones = Suspension::where('id_usuario', $cliente->id_usuario)
            ->where('fecha_desde', '>=', now()->subMonths(6))
            ->count() == 0;

        if ($sinMultas && $sinSuspensiones) {
            $cliente->puntaje += 100;
            $cliente->save();
        }
    }
}

}
