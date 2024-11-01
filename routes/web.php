<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EstacionController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\BicicletaController;
use App\Http\Controllers\AdministrativoController;
use App\Http\Controllers\ReservaController;

// Vista principal
Route::get('/', [LandingController::class, 'index'])->name('landing');

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
});

//* CLIENTE
Route::middleware(['auth', 'role:cliente'])->group(function () {
    Route::get('/inicio_cliente', [ClienteController::class, 'indexInicio'])->name('inicio_cliente');
    // Route::get('/inicio_cliente', function () {
    //     return view('cliente.partials.inicio');  // Renderiza la vista 'Inicio'
    // })->name('inicio_cliente');

    Route::get('/alquilar', function () {
        return view('cliente.partials.alquilar');  // Renderiza la vista 'Alquilar'
    })->name('alquilar');

    //TODO: Conectar alquiler a la vista actualizada del cliente
    // Alquilar que viene de lo de maxi, el controlador le devuelve las vistas que tiene que mostrar...
    // Route::get('/alquilar',  [ReservaController::class, 'indexAlquilar'])->name('alquilar.index');
    // Route::post('/alquilar/bici-disponible', [ReservaController::class, 'bicicletaDisponible'])->name('alquilar.bici-disponible');
    // Route::post('/alquilar/bici-no-disponible', [ReservaController::class, 'bicicletaNoDisponible'])->name('alquilar.bici-no-disponible');
    // Route::post('/alquilar/pagar-alquiler',  [ReservaController::class, 'pagarAlquiler'])->name('alquilar.pagar-alquiler');

    Route::get('/devolver', function () {
        return view('cliente.partials.devolver');  // Renderiza la vista 'Devolver'
    })->name('devolver');


    // TODO: Intentar que funcione todo con una única vista reservar, así podemos agrgear alguna trnasición cuando se agranda el contenedor de la vista
    Route::get('/reservar', [ReservaController::class, 'indexReserva'])->name('reservar');
    Route::post('/reservar/pasos', [ReservaController::class, 'reservarPasos'])->name('reservar.pasos');
    Route::post('/estaciones/disponibilidad-horario-retiro', [EstacionController::class, 'disponibilidadHorarioRetiro'])->name('estaciones.disponibilidad-horario-retiro');
    Route::post('/reservar/crear-reserva', [ReservaController::class, 'crearReserva'])->name('reservar.crearReserva');
    Route::post('/reservar/datos-correctos', [ReservaController::class, 'reservarDatosCorrectos'])->name('reservar.datos-correctos');
    Route::post('/reservar/datos-incorrectos', [ReservaController::class, 'reservarDatosIncorrectos'])->name('reservar.datos-incorrectos');
    Route::post('/reservar/pagar-reserva', [ReservaController::class, 'pagarReserva'])->name('reservar.pagar-reserva');

    Route::get('/perfil', function () {
        return view('cliente.partials.perfil');  // Renderiza la vista 'Perfil'
    })->name('perfil');

    Route::get('/reserva_actual', function () {
        return view('cliente.partials.reserva_actual');  // Renderiza la vista 'Reserva Actual'
    })->name('reserva_actual');

    Route::get('/alquiler_actual', function () {
        return view('cliente.partials.alquiler_actual');  // Renderiza la vista 'Alquiler Actual'
    })->name('alquiler_actual');

    Route::get('/movimientos_saldo', function () {
        return view('cliente.partials.movimientos_saldo');  // Renderiza la vista 'Movimientos del Saldo'
    })->name('mov_saldo');

    Route::get('/historial_reservas', function () {
        return view('cliente.partials.historial_reservas');  // Renderiza la vista 'Historial de Reservas'
    })->name('his_reservas');

    Route::get('/historial_multas', function () {
        return view('cliente.partials.historial_multas');  // Renderiza la vista 'Historial de Multas'
    })->name('his_multas');

    Route::get('/historial_suspensiones', function () {
        return view('cliente.partials.historial_suspensiones');  // Renderiza la vista 'Historial de Suspensiones'
    })->name('his_suspensiones');

    Route::get('/estaciones', function () {
        return view('cliente.partials.ver_estaciones');  // Renderiza la vista 'Ver Estaciones'
    })->name('ver_estaciones');

    Route::get('/mas', function () {
        return view('cliente.partials.mas_opciones');  // Renderiza la vista 'Ver Estaciones'
    })->name('mas');

    // Cargar Saldo que viene de lo de maxi, el controlador trae la vista...
    Route::get('/cargar-saldo', [ClienteController::class, 'indexCargarSaldo'])->name('cargar-saldo.index');
    Route::post('/cargar-saldo', [ClienteController::class, 'storeCargarSaldo'])->name('cargar-saldo.store');
});


// Ruta para obtener estaciones
Route::get('/estacionesMapa', [EstacionController::class, 'getEstacionesMapa'])->name('estacionesMapa');






require __DIR__ . '/auth.php';
