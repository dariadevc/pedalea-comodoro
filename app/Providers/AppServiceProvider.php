<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
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
                /** @var Usuario */
                $usuario = Auth::user();
                $cliente = $usuario->obtenerCliente();
                $reserva = $cliente->obtenerReserva();
                $existe_reserva_ajena = $cliente->obtenerReservaAjena() ? true : false;
                $view->with([
                    'reserva' => $reserva,
                    'existe_reserva_ajena' => $existe_reserva_ajena,
                ]);
            }
        });

        Paginator::useTailwind();
    }
}
