<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Danio;
use App\Models\Reserva;
use App\Models\Estacion;
use Illuminate\View\View;
use App\Rules\HorarioRetiro;
use Illuminate\Http\Request;
use App\Models\EstadoReserva;
use function Pest\Laravel\json;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Validator;

class ReservaController extends Controller
{
    // -------------
    // ALQUILAR
    // -------------

    /**
     * Muestra el formulario para alquilar una bicicleta, o redirige si hay una reserva activa o estoy suspendido.
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function indexAlquilar()
    {
        /** @var \App\Models\User $usuario */
        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();

        if ($cliente->estoySuspendido()) {
            return $this->redireccionarInicio('error', 'Su cuenta se encuentra suspendida.');
        }

        $reserva = $cliente->obtenerReservaActivaModificada();
        if ($reserva) {
            return $this->mostrarFormularioAlquilar($reserva);
        }

        return redirect()->back()->with('error', 'No hay ningun alquiler activo.');
    }

    /**
     * Redirecciona al inicio con un mensaje según la clave.
     *
     * @param string $mensaje
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redireccionarInicio(string $clave, string $mensaje): RedirectResponse
    {
        return redirect()->route('inicio')->with($clave, $mensaje);
    }

    /**
     * Muestra el formulario para alquilar una bicicleta.
     *
     * @param \App\Models\Reserva $reserva
     * @return \Illuminate\View\View
     */
    protected function mostrarFormularioAlquilar(Reserva $reserva): View
    {
        $reserva = $reserva->formatearDatosActiva();
        return view('cliente.alquilar', compact('reserva'));
    }

    /**
     * Confirmar que la bicicleta esta disponible en la estación de retiro.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function bicicletaDisponible(): JsonResponse
    {
        /** @var \App\Models\User $usuario */
        $usuario = Auth::user();
        $reserva_actual = $usuario->obtenerCliente()->obtenerReservaActivaModificada();
        $bicicleta = $reserva_actual->bicicleta;

        if ($bicicleta->estoyEnUnAlquiler()) {
            $reserva_alquilada = $bicicleta->getAlquilerActual();
            $reserva_alquilada->cerrarAlquiler();
        }

        return response()->json(['success' => true]);
    }

    /**
     * Asignar una nueva bicicleta si hay disponible en la estación de retiro o modificar la reserva.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function bicicletaNoDisponible(): JsonResponse
    {
        /** @var \App\Models\User $usuario */
        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();
        // Verificación de existencia de reserva
        $tieneReserva = $cliente->tengoUnaReserva();

        if (!$tieneReserva) {
            return response()->json([
                'success' => false,
                'mensaje' => 'El cliente no tiene ninguna reserva activa.'
            ]);
        }
        $reserva_actual = $cliente->obtenerReservaActivaModificada();

        if (!$reserva_actual || !isset($reserva_actual->id_reserva)) {

            return response()->json([
                'success' => false,
                'mensaje' => 'Reserva no encontrada.'
            ]);
        }

        $estacion_retiro = $reserva_actual->estacionRetiro;
        $nueva_bicicleta = $estacion_retiro->getBicicletaDisponibleAhora();
        if ($nueva_bicicleta) {
            $reserva_actual->asignarNuevaBicicleta($nueva_bicicleta);
            return response()->json([
                'success' => true,
                'mensaje' => 'Se le asigno una nueva bicicleta de la estación'
            ]);
        }

        $estacion_retiro = $reserva_actual->estacionRetiro;
        $bicicleta_asignada = $reserva_actual->bicicleta;

        if (is_null($bicicleta_asignada->id_estacion_actual && $reserva_actual->id_estacion_retiro != $bicicleta_asignada->id_estacion_actual)) {
            session(['id_reserva' => $reserva_actual->id_reserva]);
            return response()->json([
                'success' => false,
                'mensaje' => 'La bicicleta no está disponible en la estación.',
                'redirectUrl' => route('reservas.modificar')
            ]);
        }
        $nueva_bicicleta = $estacion_retiro->bicicletas()->whereNull('id_estacion_actual')->first();

        if ($nueva_bicicleta) {
            $reserva_actual->asignarNuevaBicicleta($nueva_bicicleta);
            session(['id_reserva' => $reserva_actual->id_reserva]);
            return response()->json([
                'success' => true,
                'mensaje' => 'Se le asignó una nueva bicicleta de la estación'
            ]);
        }

        session(['id_reserva' => $reserva_actual->id_reserva]);
        return response()->json([
            'success' => false,
            'mensaje' => 'No hay bicicletas disponibles en esta estación.',
            'redirectUrl' => route('reservas.modificar')
        ]);
    }

    /**
     * Pagar el alquiler y almacenarlo en la base de datos. Si no tiene saldo devolver un mensaje de error.
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function pagarAlquiler(Request $request): JsonResponse
    {
        $inputPagar = $request->input('pagar');

        if (!($inputPagar === '')) {
            /** @var \App\Models\User $usuario */
            $usuario = Auth::user();
            $cliente = $usuario->obtenerCliente();
            $reserva = $cliente->obtenerReservaActivaModificada();

            if ($reserva->alquilar($cliente, $usuario)) {
                return response()->json([
                    'success' => true,
                    'mensaje' => 'Alquiler realizado correctamente.',
                    'redirect' => route('inicio')
                ]);
            } else {
                return response()->json(['success' => false, 'mensaje' => 'Monto insuficiente para pagar el alquiler.']);
            }
        }
    }


    /**
     * Muestra el alquiler actual.
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function indexAlquilerActual()
    {
        /** @var \App\Models\User $usuario */
        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();

        if ($cliente->estoySuspendido()) {
            return $this->redireccionarInicio('error', 'Su cuenta se encuentra suspendida.');
        }

        $reserva = $cliente->obtenerReservaAlquiladaReasignada();
        if (!$reserva) {
            return $this->redireccionarInicio('error', 'No tiene actualmente un alquiler.');
        }

        $estado_reserva = $reserva->getNombreEstadoReserva();

        if (!$reserva->clienteDevuelve) {
            $usuario_devuelve = null;
        } else {
            $usuario_devuelve = $reserva->clienteDevuelve->usuario;
        }

        // el ' $cliente->obtenerReservaAlquiladaReasignada()' ya busca una reserva con estado alquilada o reasignada
        // si ya se verifico arriba no es bueno volver a verificar.
        // 1º arriba hay un !reserva, 2º la consulta de obtener la reserva ya te trae con alguna de los 2 estados
        //-------------------------------------
        // if ($reserva && $reserva->estoyAlquilada()) {
        //     $reserva = $reserva->formatearDatosActiva();
        //     return view('cliente.alquiler_actual', compact('reserva', 'estado_reserva', 'usuario_devuelve'));
        // }

        $reserva = $reserva->formatearDatosActiva();
        return view('cliente.alquiler_actual', compact('reserva', 'estado_reserva', 'usuario_devuelve'));
    }

    // -------------
    // REASIGNAR
    // -------------

    /**
     * Buscar el usuario por DNI y reasignar la devolución a él.
     *
     * @param Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function buscarUsuario(Request $request): JsonResponse
    {
        // TODO: Manejar excepciones
        //El cliente no puede asignarse la devolución a sí mismo.
        //El DNI tiene que estar en un rango numérico.
        //
        //Valida el DNI
        $request->validate([
            'dni' => 'required|numeric|between:20000000,99999999|digits:8',
        ]);



        /** @var \App\Models\User $usuario */
        $usuario = Auth::user();
        $dni = $request->dni;

        //Excepción: El usuario no se puede reasignar la devolución a sí mismo
        if ($usuario->dni == $dni) {
            return response()->json([
                'status' => 'error',
                'errorView' => view('cliente.partials.error_autoasignacion_reasignar')->render(),
            ]);
        }


        $cliente = $usuario->obtenerCliente();
        $reserva = $cliente->obtenerReservaAlquiladaReasignada();
        $usuario_devuelve = User::obtenerUsuarioPorDni($request->dni);

        if (!$usuario_devuelve) {
            return response()->json([
                'status' => 'error',
                'errorView' => view('cliente.partials.error_reasignar')->render(),
            ]);
        }

        // Comprueba que usuario exista y que sea un cliente
        $cliente_devuelve = $usuario_devuelve->obtenerCliente();
        if (!$cliente_devuelve) {
            return response()->json([
                'status' => 'error',
                'errorView' => view('cliente.partials.error_reasignar')->render(),
            ]);
        }
        if (!$cliente_devuelve->estoySuspendido()) {
            $reserva->reasignarDevolucion($cliente_devuelve);

            // Devuelve el JSON que le paso a la vista a través de ajax para modificar los contenedores #usuario_devuelve y #tarjeta_reasignar
            return response()->json([
                'status' => 'success',
                'successView' => view('cliente.partials.exito_reasignar')->render(),
            ]);
        }
        return response()->json([
            'status' => 'error',
            'errorView' => view('cliente.partials.usuario_suspendido_reasignar')->render(),
        ]);
    }

    // -------------
    // RESERVAR
    // -------------

    /**
     * Muestra el formulario para reservar una bicicleta.
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function indexReserva()
    {
        /** @var \App\Models\User $usuario */
        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();

        if ($cliente->estoySuspendido()) {
            return $this->redireccionarInicio('error', 'Su cuenta se encuentra suspendida.');
        }

        if (!($cliente->tengoUnaReserva())) {
            return view('cliente.reservar')->render();
        }
        return $this->redireccionarInicio('error', 'Ya tiene una reserva activa.');
    }

    /**
     * Crea una nueva reserva y la almacena en la session.
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function crearReserva(Request $request): JsonResponse
    {
        $validador = Validator::make($request->all(), [
            'horario_retiro_reserva' => ['required', new HorarioRetiro],
            'estacion_retiro' => 'required|integer|exists:estaciones,id_estacion',
            'estacion_devolucion' => 'required|integer|exists:estaciones,id_estacion',
            'tiempo_uso' => 'required|integer|min:1|max:6',
        ], [
            'estacion_retiro.required' => 'La estación de retiro es obligatoria.',
            'estacion_retiro.integer' => 'La estación de retiro debe ser un número.',
            'estacion_retiro.exists' => 'La estación de retiro seleccionada no existe.',
            'estacion_devolucion.required' => 'La estación de devolución es obligatoria.',
            'estacion_devolucion.integer' => 'La estación de devolución debe ser un número.',
            'estacion_devolucion.exists' => 'La estación de devolución seleccionada no existe.',
            'tiempo_uso.required' => 'El tiempo de uso es obligatorio.',
            'tiempo_uso.integer' => 'El tiempo de uso debe ser un número.',
            'tiempo_uso.min' => 'El tiempo de uso mínimo es 1 hora.',
            'tiempo_uso.max' => 'El tiempo de uso máximo es 6 horas.',
        ]);

        if ($validador->fails()) {
            // Si hay errores, devolvemos los mensajes como JSON con el código de estado 422
            return response()->json(['errors' => $validador->errors()], 422);
        }
        $reserva_pendiente = Reserva::crearReserva(
            $request->input('horario_retiro_reserva'),
            $request->input('tiempo_uso'),
            $request->input('estacion_devolucion'),
            $request->input('estacion_retiro'),
            Auth::user()->id_usuario,
        );
        session(['reserva_pendiente' => $reserva_pendiente]);

        return response()->json([
            'success' => true,
        ]);
    }


    public function reservarDatosCorrectos(Request $request)
    {
        return response()->json(['success' => true]);
    }

    public function reservarDatosIncorrectos(Request $request)
    {
        return response()->json([
            'success' => true,
            'mensaje' => 'Datos incorrectos.',
            'redirect' => route('reservar')
        ]);
    }

    /**
     * Muestra el formulario para reservar una bicicleta según el paso actual.
     *
     * @param Request $request
     * 
     * @return string|void
     */
    public function reservarPasos(Request $request): string
    {
        switch ($request->input('paso')) {
            case '1':
                return view('cliente.partials.reservas.elegir-datos')->render();

            case '2':
                $reserva_pendiente = session('reserva_pendiente');
                $reserva_formateada = $reserva_pendiente->formatearDatosParaReservar();
                return view('cliente.partials.reservas.confirmar', ['reserva' => $reserva_formateada])->render();
            case '3':
                $reserva_pendiente = session('reserva_pendiente');
                $reserva_formateada = $reserva_pendiente->formatearDatosParaReservar();
                return view('cliente.partials.reservas.pagar-reserva', ['reserva' => $reserva_formateada])->render();
        }
    }

    /**
     * Pagar la reserva y almacenarlo en la base de datos. Si no tiene saldo devolver un mensaje de error.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function pagarReserva(): JsonResponse
    {
        /** @var \App\Models\User $usuario */
        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();
        /** @var \App\Models\Reserva $reserva */
        $reserva = session('reserva_pendiente');

        // falta si la reserva no existe, esto:
        // if (!reserva) {}

        if ($reserva->reservar($cliente, $usuario)) {
            session()->forget('reserva_pendiente');

            return response()->json([
                'success' => true,
                'mensaje' => 'Reserva realizada correctamente.',
                'redirect' => route('inicio')
            ]);
        }
        return response()->json(['success' => false, 'mensaje' => 'No se pudo realizar la reserva.']);
    }

    /**
     * Muestra la reserva actual.
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function indexReservaActual()
    {
        /** @var \App\Models\User $usuario */
        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();

        if ($cliente->estoySuspendido()) {
            return $this->redireccionarInicio('error', 'Su cuenta se encuentra suspendida.');
        }

        $reserva = $cliente->obtenerReservaActivaModificada();

        if (!$reserva) {
            return $this->redireccionarInicio('error', 'No tiene actualmente una reserva.');
        }

        $reserva = $reserva->formatearDatosActiva();
        return view('cliente.reserva_actual', compact('reserva'));
    }

    //////////////////
    //Modificar Reserva
    //////////////////

    /**
     * Muestra el formulario para modificar una reserva.
     * 
     * @param Request $request
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function modificarReservaC(Request $request)
    {
        /** @var \App\Models\User $usuario */
        $usuario = Auth::user();
        $reserva_id = session('id_reserva');

        if (!$reserva_id) {
            return response()->json([
                'success' => false,
                'mensaje' => 'No se ha encontrado la reserva en la sesión.'
            ]);
        }

        $reserva = Reserva::find($reserva_id);

        if (!$reserva) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Reserva no encontrada.'
            ]);
        }

        $nuevoHoraRetiro = $reserva->fecha_hora_retiro->addMinutes(15);
        $nuevaEstacionYBicicleta = Reserva::obtenerNuevaEstacionYBicicleta($reserva->id_estacion_retiro, $nuevoHoraRetiro->format('H:i:s'));

        if (!$nuevaEstacionYBicicleta) {
            return response()->json([
                'success' => false,
                'mensaje' => 'No hay bicicletas disponibles en las estaciones cercanas.'
            ]);
        }
        $nuevaEstacion = Estacion::find($nuevaEstacionYBicicleta['nuevaEstacionId']);
        $nuevaBicicleta = $nuevaEstacionYBicicleta['bicicleta'];
        $nuevoHoraDevolucion = $reserva->fecha_hora_devolucion->addMinutes(15);

        return view('cliente.modificar_reserva', compact('reserva', 'nuevaEstacion', 'nuevaBicicleta', 'nuevoHoraRetiro', 'nuevoHoraDevolucion'));
    }


    /**
     * Confirmar la modificación de una reserva.
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function confirmarModificacionReserva(Request $request)
    {
        $request->validate([
            'id_reserva' => 'required|integer',
            'id_bicicleta' => 'required|integer',
            'id_estacion_retiro' => 'required|integer',
            'nuevoHorarioRetiro' => 'required|date',
            'nuevoHorarioDevolucion' => 'required|date',
        ]);

        $reserva = Reserva::find($request->id_reserva);

        if (!$reserva) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Reserva no encontrada.'
            ]);
        }
        //Actuzalimos los datos y los guardamos en la BD
        $reserva->id_bicicleta = $request->id_bicicleta;
        $reserva->id_estacion_retiro = $request->id_estacion_retiro;
        $reserva->id_estado = 5;
        $reserva->fecha_hora_retiro = $request->nuevoHorarioRetiro;
        $reserva->fecha_hora_devolucion = $request->nuevoHorarioDevolucion;
        $reserva->save();

        return redirect()->route('reserva_actual')->with('success', 'Reserva modificada correctamente.');
    }

    /**
     * Rechazar la modificación de una reserva.
     * 
     * @param Request $request
     * @param Reserva $reserva
     * 
     * @return \Illuminate\Http\JsonResponse|
     */
    public function rechazarModificacion(Request $request, Reserva $reserva)
    {
        $request->validate([
            'id_reserva' => 'required|integer|exists:reservas,id_reserva',
        ]);

        $idReserva = $request->input('id_reserva');
        $reserva = Reserva::find($idReserva);

        if (!$reserva) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Reserva no encontrada.'
            ]);
        }

        if (is_null($reserva->senia)) {
            return response()->json([
                'success' => false,
                'mensaje' => 'El campo senia es null.'
            ]);
        }
        /** @var \App\Models\User $usuario */
        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();

        if (!$cliente) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Cliente no encontrado.'
            ]);
        }


        $senia = $reserva->senia;
        $motivo = 'Devolución de seña';
        $cliente->agregarSaldo($senia, $motivo);

        $reserva->cambiarEstado(EstadoReserva::CANCELADA);
        $reserva->save();

        return $this->redireccionarInicio('success', 'Reserva cancelada y saldo devuelto exitosamente.');
    }

    /**
     * Guarda la url en la session.
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function guardarUrlIrCargarSaldo(Request $request): JsonResponse
    {
        $url_actual = $request->url_actual;

        session(['url_actual' => $url_actual]);
        return response()->json([
            'success' => true,
            'redirigir' => route('cargar-saldo.index'),
        ]);
    }

    /**
     * Cancelar una reserva.
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelar(Request $request): RedirectResponse
    {
        $reserva = Reserva::findOrFail($request->id_reserva);
        if (!$reserva) {
            return redirect()->route('reserva_actual')->with('error', 'Reserva no encontrada.');
        }

        $mensaje = $reserva->cancelar();
        return $this->redireccionarInicio('success', $mensaje);
    }

    /**
     * Muestra el formulario para devolver una bicicleta.
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function indexDevolver()
    {
        /** @var \App\Models\User $usuario */
        $usuario = Auth::user();
        $cliente = $usuario->obtenerCliente();
        $reserva = $cliente->obtenerReservaAlquilada();

        if (!$reserva) {
            return $this->redireccionarInicio('error', 'No tiene un alquiler activo.');
        }

        session()->put('reserva_devolver', $reserva);
        return view('cliente.devolver2');
    }

    /**
     * Muestra el formulario para devolver una bicicleta.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function mostrarDanios(Request $request): JsonResponse
    {
        $danios = Danio::all();
        $vista_html = view('cliente.partials.devolver.formulario-danio', compact('danios'))->render();
        return response()->json([
            'success' => true,
            'html' => $vista_html,
        ]);
    }

    /**
     * Guarda los danios seleccionados en la session.
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function guardarDanios(Request $request): JsonResponse
    {
        $validador = Validator::make($request->all(), [
            'elementos' => 'required|array|min:1',
        ], [
            'elementos.required' => 'Debes seleccionar al menos un elemento.',
            'elementos.min' => 'Debes seleccionar al menos un elemento.',
        ]);

        if ($validador->fails()) {
            // Si hay errores, devolvemos los mensajes como JSON con el código de estado 422
            return response()->json(['errors' => $validador->errors()], 422);
        }

        $elementosSeleccionados = $request->input('elementos', []);
        session()->put('daniosSeleccionados', $elementosSeleccionados);

        $vista_calificar = $this->mostrarCalificacion();
        return response()->json(['success' => true, 'html' => $vista_calificar]);
    }

    /**
     * Guarda que no tuvo daños la bicicleta en la session.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function sinDanios(): JsonResponse
    {
        session()->put('daniosSeleccionados', []);
        $vista_calificar = $this->mostrarCalificacion();
        return response()->json(['success' => true, 'html' => $vista_calificar]);
    }

    /**
     * Muestra el formulario para devolver una bicicleta.
     * 
     * @return string Retorna una vista renderizada.
     */
    public function mostrarCalificacion(): string
    {
        return view('cliente.partials.devolver.formulario-calificacion')->render();
    }

    /**
     * Guarda la calificación de la estación de retiro y devolución en la session.
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function guardarCalificacion(Request $request): JsonResponse
    {
        $validador = Validator::make($request->all(), [
            'calificacion_retiro' => 'required|integer|min:1|max:5',
            'calificacion_devolucion' => 'required|integer|min:1|max:5',
        ], [
            'calificacion_retiro.required' => 'La calificación de la estación de retiro es obligatoria.',
            'calificacion_retiro.integer' => 'La calificación debe ser un número entero.',
            'calificacion_retiro.min' => 'La calificación debe ser al menos 1.',
            'calificacion_retiro.max' => 'La calificación no puede ser mayor a 5.',
            'calificacion_devolucion.required' => 'La calificación de la estación de devolución es obligatoria.',
            'calificacion_devolucion.integer' => 'La calificación debe ser un número entero.',
            'calificacion_devolucion.min' => 'La calificación debe ser al menos 1.',
            'calificacion_devolucion.max' => 'La calificación no puede ser mayor a 5.',
        ]);

        $calificaciones = [
            'id_tipo_calificacion_retiro' => $request->calificacion_retiro,
            'id_tipo_calificacion_devolucion' => $request->calificacion_devolucion
        ];
        session()->put('calificaciones', $calificaciones);

        if ($validador->fails()) {
            // Si hay errores, devolvemos los mensajes como JSON con el código de estado 422
            return response()->json(['errors' => $validador->errors()], 422);
        }

        $vista_html = $this->mostrarDevolverBicicleta();

        return response()->json([
            'success' => true,
            'html' => $vista_html,
        ]);
    }

    /**
     * Muestra el formulario para devolver una bicicleta.
     * 
     * @return string Retorna una vista renderizada.
     */
    public function mostrarDevolverBicicleta(): string
    {
        return view('cliente.partials.devolver.confirmacion-devolucion')->render();
    }

    /**
     * Confirmar la devolución de una bicicleta.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function devolverConfirmar(): RedirectResponse
    {
        if (!session()->has('daniosSeleccionados')) {
            return redirect()->route('devolver.index')->with('error', 'No eligio si tuvo daños o no la bicicleta.');
        }
        if (!session()->has('calificaciones')) {
            return redirect()->route('devolver.index')->with('error', 'No califico las estaciones de devolucion y retiro.');
        }
        if (!session()->has('reserva_devolver')) {
            return redirect()->route('devolver.index')->with('error', 'No se encontro la reserva.');
        }
        /** @var Reserva $reserva */
        $reserva = session('reserva_devolver');
        $daniosSeleccionados = session('daniosSeleccionados');
        $calificaciones = session('calificaciones');
        $danios_objetos = [];
        foreach ($daniosSeleccionados as $id_danio) {
            $danios_objetos[] = Danio::findOrFail($id_danio);
        }
        $reserva->devolver($danios_objetos, $calificaciones);
        return $this->redireccionarInicio('success', 'Alquiler finalizado con éxito.');
    }
}
