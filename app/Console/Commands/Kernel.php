<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define los comandos Artisan que deben registrarse.
     */
    protected $commands = [
        // Registrar el comando
        Commands\ChequeoReservasVencidas::class,
        Commands\PremiarBuenaConducta::class,
    ];

    /**
     * Define la programación de las tareas recurrentes.
     */
    protected function schedule(Schedule $schedule)
    {
        // Programar el comando para que se ejecute diariamente
        $schedule->command('app:chequeo-reservas-vencidas')->daily();

        $schedule->command('app:premiar-buena-conducta')->everySixMonths();
    }

    /**
     * Registra los comandos para la aplicación.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
