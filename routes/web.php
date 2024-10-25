<?php

use App\Http\Controllers\AdministrativoController;
use App\Http\Controllers\BicicletaController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EstacionController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\InformeController;

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
Route::middleware('auth')->group(function () {
    Route::get('/inicio', [InicioController::class, 'index'])->name('inicio');
});


Route::middleware(['auth', 'role:administrativo'])->group(function () {

    // Rutas para gestión de bicicletas
    Route::get('/bicicletas', [BicicletaController::class, 'index'])->name('bicicletas.index');
    Route::get('/bicicletas/create', [BicicletaController::class, 'create'])->name('bicicletas.create');
    Route::post('/bicicletas', [BicicletaController::class, 'store'])->name('bicicletas.store');
    Route::get('/bicicletas/edit/{bicicleta}', [BicicletaController::class, 'edit'])->name('bicicletas.edit');
    Route::put('/bicicletas/{bicicleta}', [BicicletaController::class, 'update'])->name('bicicletas.update');
    Route::delete('/bicicletas/{bicicleta}', [BicicletaController::class, 'destroy'])->name('bicicletas.destroy');

    // Rutas para gestión de estaciones
    Route::get('/estaciones', [EstacionController::class, 'index'])->name('estaciones.index');
    Route::get('/estaciones/create', [EstacionController::class, 'create'])->name('estaciones.create');
    Route::post('/estaciones', [EstacionController::class, 'store'])->name('estaciones.store');
    Route::get('/estaciones/edit/{estacion}', [EstacionController::class, 'edit'])->name('estaciones.edit');
    Route::put('/estaciones/{estacion}', [EstacionController::class, 'update'])->name('estaciones.update');
    Route::delete('/estaciones/{estacion}', [EstacionController::class, 'destroy'])->name('estaciones.destroy');

    // Rutas para gestion tarifas
    Route::get('/modificar-tarifa', [AdministrativoController::class, 'editTarifa'])->name('administrativo.editTarifa');
    Route::put('/modificar-tarifa', [AdministrativoController::class, 'updateTarifa'])->name('administrativo.updateTarifa');

    Route::get('/multas', [InformeController::class, 'multas'])->name('informes.multas');
});

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


// Ruta para obtener estaciones
Route::get('/estacionesMapa', [EstacionController::class, 'getEstacionesMapa'])->name('estacionesMapa');




require __DIR__ . '/auth.php';
