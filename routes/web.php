<?php

use App\Http\Controllers\EstacionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Vista principal
Route::get('/', function () {
    return view('invitado.landing'); // Vista por defecto
})->name('landing');

//* Por ahora voy a trabajar con las vistas sueltas, pero estas dos deberían estar agrupadas en el grupo de invitados
Route::get('/iniciar-sesion', function () {
    return view('invitado.iniciar_sesion'); // Vista para iniciar sesión
})->name('iniciar_sesion');
Route::get('/registrarse', function () {
    return view('invitado.registrarse'); // Vista para registrarse
})->name('registrarse');

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

// Ruta para el dashboard de usuario
Route::middleware(['auth', 'role:cliente'])->group(function () {
    Route::get('/cliente/inicio', function () {
        return view('cliente.inicio'); // Vista para el usuario
    })->name('cliente.home');
});

// Ruta para el dashboard de administrador
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.inicio'); // Vista para el administrador
    })->name('admin.home');
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


require __DIR__ . '/auth.php';
