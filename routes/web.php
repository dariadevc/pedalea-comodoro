<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('invitado.landing');
});

Route::get('/alquilar', function () {
    return view('cliente.alquilar');  // Renderiza la vista 'home.blade.php'
});

Route::get('/devolver', function () {
    return view('cliente.devolver');  // Renderiza la vista 'home.blade.php'
});

Route::get('/reservar', function () {
    return view('cliente.reservar');  // Renderiza la vista 'home.blade.php'
});