<?php

use App\Http\Controllers\EstacionController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


// Vista principal
Route::get('/', function () {
    return view('invitado.landing'); // Vista por defecto
})->name('landing');


// NO ELIMINAR, cuando hagamos la parte del perfil nos puede ayudar
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });


// Ruta para redirigir a inicio
Route::middleware('auth')->group(function () {
    Route::get('/inicio', [InicioController::class, 'index'])->name('inicio');
});


// Rutas para el cliente
Route::middleware(['auth', 'role:cliente'])->group(function () {
    Route::get('/alquilar', function () {
        return view('cliente.alquilar');  // Renderiza la vista 'home.blade.php'
    })->name('alquiler');

    Route::get('/devolver', function () {
        return view('cliente.devolver');  // Renderiza la vista 'home.blade.php'
    });

    Route::get('/reservar', function () {
        return view('cliente.reservar');  // Renderiza la vista 'home.blade.php'
    });
});


// Ruta para obtener estaciones, protegida por autenticación y CSRF
Route::get('/estacionesMapa', [EstacionController::class, 'getEstacionesMapa'])->name('estacionesMapa');


require __DIR__ . '/auth.php';
