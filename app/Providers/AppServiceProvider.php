<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.cliente', function ($view) {
            if (Auth::check()) {
                /** @var \App\Models\User $usuario */
                $usuario = Auth::user();
                $reserva = $usuario->obtenerCliente()->obtenerReserva();
                $view->with('reserva', $reserva);
            }
        });
        Paginator::useTailwind();
    }
}
