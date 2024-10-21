<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EstacionController;

// Vista principal
Route::get('/', function () {
    return view('invitado.landing'); // Vista por defecto
})->name('landing');



//? Cuando lo meto en el grupo de rutas para invitados no me permite entrar a esas vistas, ¿no me reconoce como invitado?
// // Grupo de rutas para invitados
// Route::middleware('guest')->group(function () {
//     Route::get('/iniciar-sesion', function () {
//         return view('invitado.iniciar_sesion'); // Vista para iniciar sesión
//     })->name('iniciar_sesion');
//     Route::get('/registrarse', function () {
//         return view('invitado.registrarse'); // Vista para registrarse
//     })->name('registrarse');
// });


// Esta se puede sacar
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware(['auth', 'role:administrativo'])->group(function () {
    Route::get('/admin-inicio', function () {
        return view('administrativo.inicio'); // Vista para el administrador
    })->name('administrativo.inicio');
});

Route::middleware(['auth', 'role:cliente'])->group(function () {
    Route::get('/inicio', function () {
        return view('cliente.inicio'); // Vista para el usuario
    })->name('cliente.inicio');
});





Route::get('/alquilar', function () {
    return view('cliente.alquilar');  // Renderiza la vista 'home.blade.php'
})->name('alquiler');

Route::get('/devolver', function () {
    return view('cliente.devolver');  // Renderiza la vista 'home.blade.php'
});

Route::get('/reservar', function () {
    return view('cliente.reservar');  // Renderiza la vista 'home.blade.php'
});


// Ruta para obtener estaciones, protegida por autenticación y CSRF
Route::get('/estacionesMapa', [EstacionController::class, 'getEstacionesMapa'])->name('estacionesMapa');



Route::get('/send-test-email', function () {
    Mail::raw('Este es un correo de prueba enviado desde Laravel usando Mailtrap.', function ($message) {
        $message->to('clientebike1@gmail.com')
                ->subject('Correo de Prueba');
    });

    return 'Correo de prueba enviado!';
});



require __DIR__ . '/auth.php';
