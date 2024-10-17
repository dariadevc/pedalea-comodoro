<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('invitado.landing');
});

Route::get('/alquilar', function () {
    return view('cliente.alquilar');  // Renderiza la vista 'home.blade.php'
});