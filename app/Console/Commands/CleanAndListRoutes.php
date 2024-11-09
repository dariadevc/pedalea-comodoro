<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanAndListRoutes extends Command
{
    /**
     * El nombre del comando de consola.
     *
     * @var string
     */
    protected $signature = 'clean:laravel';

    /**
     * La descripción del comando de consola.
     *
     * @var string
     */
    protected $description = 'Comando que limpia varias cachés de Laravel y lista las rutas.';

    /**
     * Maneja la ejecución del comando de consola.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('route:clear');
        $this->call('view:clear');
        $this->call('event:clear');
        $this->call('route:list');
        $this->info('Cache cleared and routes listed successfully.');
    }
}
