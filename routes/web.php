<?php

use App\Http\Controllers\EstacionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Esta se puede sacar
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Ruta para el dashboard de usuario
Route::middleware(['auth', 'role:cliente'])->group(function () {
    Route::get('/cliente/dashboard', function () {
        return view('cliente.dashboard'); // Vista para el usuario
    })->name('cliente.dashboard');
});

// Ruta para el dashboard de administrador
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard'); // Vista para el administrador
    })->name('admin.dashboard');
});

// Route::get('/', function () {
//     return view('welcome'); // Vista por defecto
// })->name('home');

Route::get('/', function () {
    return view('invitado.landing');
    // ->name('home');
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


// Ruta para obtener estaciones, protegida por autenticación y CSRF
Route::get('/estacionesMapa', [EstacionController::class, 'getEstacionesMapa'])->name('estacionesMapa');


require __DIR__.'/auth.php';