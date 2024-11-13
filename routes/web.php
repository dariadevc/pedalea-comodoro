<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\EstacionController;
use App\Http\Controllers\BicicletaController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\InfraccionController;
use App\Http\Controllers\AdministrativoController;


// Vista principal
Route::get('/', [LandingController::class, 'index'])->name('landing');


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

    //Rutas para la gestion de informes:

    //Ruta para el menu de informes:
    Route::get('/Informes', [InformeController::class, 'informe'])->name('informes');
    Route::get('/informe/multas', [InformeController::class, 'informeMultas'])->name('informes.multas');
    Route::get('/informe/estaciones', [InformeController::class, 'informeEstaciones'])->name('informes.estaciones');
    Route::get('/informe/rutas', [InformeController::class, 'informeRutas'])->name('informes.rutas');
    Route::get('/informe/alquiler', [InformeController::class, 'informeTiempoAlquilerHorarioDemanda'])->name('informes.tiempoHorario');
});

//* INSPECTOR
Route::middleware(['auth', 'role:inspector'])->group(function () {

    // Rutas para gestión de bicicletas
    Route::get('/deshabilitar-bicicleta', [BicicletaController::class, 'vistaDeshabilitar'])->name('inspector.bicicletas');
    Route::get('/infraccion', [InfraccionController::class, 'index'])->name('inspector.infraccion');
    Route::post('/bicicletas/deshabilitar', [BicicletaController::class, 'deshabilitar'])->name('bicicletas.deshabilitar');
    Route::put('/bicicletas/deshabilitar', [BicicletaController::class, 'deshabilitar'])->name('bicicletas.deshabilitar');
    Route::get('/inspector', function () {
        return view('inspector.inicio');
    })->name('inspector.inicio');
    Route::post('/generar-infraccion', [InfraccionController::class, 'generarInfraccion'])->name('infraccion.generar');
});

//* CLIENTE
Route::middleware(['auth', 'role:cliente'])->group(function () {
    Route::get('/alquilar',  [ReservaController::class, 'indexAlquilar'])->name('alquilar.index'); // Renderiza la vista 'home.blade.php'
    Route::post('/alquilar/bici-disponible', [ReservaController::class, 'bicicletaDisponible'])->name('alquilar.bici-disponible');
    Route::post('/alquilar/bici-no-disponible', [ReservaController::class, 'bicicletaNoDisponible'])->name('alquilar.bici-no-disponible');
    Route::post('/alquilar/pagar-alquiler',  [ReservaController::class, 'pagarAlquiler'])->name('alquilar.pagar-alquiler');



    Route::get('/reservar', [ReservaController::class, 'indexReserva'])->name('reservar.index');
    Route::get('/alquiler-actual',  [ReservaController::class, 'indexAlquilerActual'])->name('alquiler_actual');
    Route::post('/alquiler-actual/buscar-usuario', [])->name('alquiler_actual.buscar-usuario');




    // TODO: Intentar que funcione todo con una única vista reservar, así podemos agrgear alguna trnasición cuando se agranda el contenedor de la vista
    Route::get('/reservar', [ReservaController::class, 'indexReserva'])->name('reservar');
    Route::post('/reservar/pasos', [ReservaController::class, 'reservarPasos'])->name('reservar.pasos');
    Route::post('/estaciones-disponibilidad-horario-retiro', [EstacionController::class, 'disponibilidadHorarioRetiro'])->name('estaciones.disponibilidad-horario-retiro');
    Route::post('/reservar/crear-reserva', [ReservaController::class, 'crearReserva'])->name('reservar.crearReserva');
    Route::post('/reservar/datos-correctos', [ReservaController::class, 'reservarDatosCorrectos'])->name('reservar.datos-correctos');
    Route::post('/reservar/datos-incorrectos', [ReservaController::class, 'reservarDatosIncorrectos'])->name('reservar.datos-incorrectos');
    Route::post('/reservar/pagar-reserva', [ReservaController::class, 'pagarReserva'])->name('reservar.pagar-reserva');

    Route::get('/reserva-actual', [ReservaController::class, 'indexReservaActual'])->name('reserva_actual');
    Route::post('/reserva-actual/buscar-usuario', [ReservaController::class, 'buscarUsuario'])->name('reserva_actual.buscar_usuario');

    Route::get('/reserva-actual/formulario-busqueda', function () {
        return view('cliente.partials.buscar_usuario_reasignar');
    })->name('reserva-actual.buscar-usuario');

    Route::post('/cancelar-reserva', [ReservaController::class, 'cancelar'])->name('reserva-actual.cancelar');

    Route::get('/perfil', [ClienteController::class, 'verPerfilCliente'])->name('perfil');


    // Route::get('/movimiento_saldo', [HistorialController::class, 'historialMovimientos'])->name('mov_saldo');

    // Route::get('/actividad', [HistorialController::class, 'historialReservas'])->name('actividad');

    // Route::get('/historial_multas', [HistorialController::class, 'historialMultas'])->name('his_multas');

    // Route::get('/historial_suspenciones', [HistorialController::class, 'historialSuspensiones'])->name('his_suspensiones');

    Route::get('/estaciones-ver-mapa', [EstacionController::class, 'verMapaCliente'])->name('ver-mapa');

    Route::get('/mas', function () {
        return view('cliente.mas_opciones');  // Renderiza la vista 'Ver Estaciones'
    })->name('mas');

    // Cargar Saldo que viene de lo de maxi, el controlador trae la vista...
    Route::get('/cargar-saldo', [ClienteController::class, 'indexCargarSaldo'])->name('cargar-saldo.index');
    Route::post('/cargar-saldo', [ClienteController::class, 'storeCargarSaldo'])->name('cargar-saldo.store');
    Route::post('/mostrar-cargar-saldo-modal', [ClienteController::class, 'mostrarCargarSaldoModal'])->name('cargar-saldo.mostrar-modal');

    //Modificar Reserva:
    Route::post('/guardar-url-ir-cargar-saldo', [ReservaController::class, 'guardarUrlIrCargarSaldo'])->name('guardar-url-ir-cargar-saldo');
    Route::get('/modificar-reserva', [ReservaController::class, 'modificarReservaC'])->name('reservas.modificar');
    Route::post('/confirmar-modificacion', [ReservaController::class, 'confirmarModificacionReserva'])->name('reservar.confirmarModificacion');
    Route::post('/rechazar-modificacion', [ReservaController::class, 'rechazarModificacion'])->name('reservas.rechazarModificacion');

    //Prueba para los historiales:
    Route::get('/historial-reserva', [HistorialController::class, 'historialReservas'])->name('historiales.reservas');
    Route::get('/historial-multa', [HistorialController::class, 'historialMultas'])->name('historiales.multas');
    Route::get('/historial-suspension', [HistorialController::class, 'historialSuspensiones'])->name('historiales.suspensiones');
    Route::get('/historial-movimiento', [HistorialController::class, 'historialMovimientos'])->name('historiales.movimientos');
});




// Ruta para obtener estaciones
Route::get('/estacionesMapa', [EstacionController::class, 'getEstacionesMapa'])->name('estacionesMapa');





require __DIR__ . '/auth.php';
