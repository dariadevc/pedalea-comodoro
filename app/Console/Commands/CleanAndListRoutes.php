<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanAndListRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:laravel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function handle()
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
