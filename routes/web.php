<?php

use App\Http\Controllers\EstacionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;

// Vista principal
Route::get('/', function () {
    return view('invitado.landing'); // Vista por defecto
})->name('landing');



//? Cuando lo meto en el grupo de rutas para invitados no me permite entrar a esas vistas, ¿no me reconoce como invitado?
// Grupo de rutas para invitados
Route::middleware('guest')->group(function () {
    Route::get('/iniciar-sesion', function () {
        return view('invitado.iniciar_sesion'); // Vista para iniciar sesión
    })->name('iniciar_sesion');
    Route::get('/registrarse', function () {
        return view('invitado.registrarse'); // Vista para registrarse
    })->name('registrarse');
});


// Esta se puede sacar
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Ruta para redirigir según el rol
Route::middleware('auth')->group(function () {
    Route::get('/inicio', function () {
        $user = Auth::user();

        if ($user->hasRole('cliente')) {
            return view('cliente.inicio');
        } elseif ($user->hasRole('administrativo')) {
            return view('administrativo.inicio');
        } elseif ($user->hasRole('inspector')) {
            return view('inspector.inicio');
        }

        // Si no tiene rol, lo manda al landing
        return redirect()->route('landing');
    })->name('inicio');
});

// Vistas del administrativo
// Route::middleware(['auth', 'role:inspector'])->group(function () {

// });


// Vistas del inspector
// Route::middleware(['auth', 'role:inspector'])->group(function () {

// });

// Vistas del cliente
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
