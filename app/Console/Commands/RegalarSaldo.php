<?php

namespace App\Console\Commands;

use App\Models\Cliente;
use Illuminate\Console\Command;

class RegalarSaldo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:regalar-saldo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Chequea si los clientes cada fin de mes tienen puntaje positivo mayor a 100 y se les otorga saldo de regalo';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $puntosRequeridos = 100; 
        $saldoRecompensa = 50; 

        $clientes = Cliente::where('puntaje', '>', $puntosRequeridos)->get();

        foreach ($clientes as $cliente) {
            $cliente->saldo += $saldoRecompensa;
            $cliente->save();
            $this->info("Se ha recompensado al cliente con ID {$cliente->id_usuario} con {$saldoRecompensa} de saldo.");
        }

        $this->info('Recompensa de saldo aplicada a los clientes elegibles.');
        return 0;
    }
}
