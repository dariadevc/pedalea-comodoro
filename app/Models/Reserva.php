<?php

namespace App\Models;

use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Mail\MailTextoSimple;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas';
    protected $primaryKey = 'id_reserva';
    public $timestamps = false;


    protected $fillable = [
        'id_bicicleta',
        'id_estacion_retiro',
        'id_estacion_devolucion',
        'id_estado',
        'id_cliente_reservo',
        'id_cliente_devuelve',
        'fecha_hora_retiro',
        'fecha_hora_devolucion',
        'monto',
        'senia',
        'puntaje_obtenido',
    ];

    protected $guarded = [
        'id_reserva',
    ];

    protected $dates = [
        'fecha_hora_devolucion',
        'fecha_hora_retiro',
    ];



    /**
     * Verifica si la reserva está en estado de reservada.
     *
     * @return bool
     */
    public function estoyReservada(): bool
    {
        return in_array($this->id_estado, [EstadoReserva::ACTIVA, EstadoReserva::MODIFICADA]);
    }

    /**
     * Verifica si la reserva está alquilada.
     *
     * @return bool
     */
    public function estoyAlquilada(): bool
    {
        return in_array($this->id_estado, [EstadoReserva::ALQUILADA, EstadoReserva::REASIGNADA]);
    }

    /**
     * Verifica si la reserva ha sido reasignada.
     *
     * @return bool
     */
    public function estoyReasignada(): bool
    {
        return $this->id_estado == EstadoReserva::REASIGNADA;
    }

    /**
     * Crea una nueva reserva.
     *
     * @param string $horario_retiro Horario de retiro
     * @param int $tiempo_uso Tiempo de uso en horas
     * @param int $id_estacion_devolucion ID de la estación de devolución
     * @param int $id_estacion_retiro ID de la estación de retiro
     * @param int $id_cliente_reservo ID del cliente que reserva
     * @return self
     */
    public static function crearReserva(string $horario_retiro, int $tiempo_uso, int $id_estacion_devolucion, int $id_estacion_retiro, int $id_cliente_reservo): self
    {
        $tiempo_uso = $tiempo_uso;
        $id_estacion_devolucion = $id_estacion_devolucion;
        $id_estacion_retiro = $id_estacion_retiro;
        $id_cliente_reservo = $id_cliente_reservo;
        $tarifa = Configuracion::where('clave', 'tarifa')->first();
        $fecha_hora_retiro = Carbon::today()->setTimeFromTimeString($horario_retiro);
        $fecha_hora_devolucion = (clone $fecha_hora_retiro)->addHours($tiempo_uso);
        $id_estado = null; // Es null porque todavía no se pagó la reserva
        $monto = $tarifa->valor * $tiempo_uso;
        $senia = $monto * 0.25;
        $estacion_retiro = Estacion::find($id_estacion_retiro);
        $bicicleta = $estacion_retiro->getBicicletaDisponibleAhora();
        if ($bicicleta === null) {
            $bicicleta = $estacion_retiro->getBicicletaDisponibleEnEstaHora($horario_retiro);
        }

        $nueva_reserva = new self();
        $nueva_reserva->id_bicicleta = $bicicleta->id_bicicleta;
        $nueva_reserva->id_estacion_retiro = $id_estacion_retiro;
        $nueva_reserva->id_estacion_devolucion = $id_estacion_devolucion;
        $nueva_reserva->id_estado = $id_estado;
        $nueva_reserva->id_cliente_reservo = $id_cliente_reservo;
        $nueva_reserva->id_cliente_devuelve = null;
        $nueva_reserva->fecha_hora_retiro = $fecha_hora_retiro;
        $nueva_reserva->fecha_hora_devolucion = $fecha_hora_devolucion;
        $nueva_reserva->monto = $monto;
        $nueva_reserva->senia = $senia;
        $nueva_reserva->puntaje_obtenido = null;

        return $nueva_reserva;
    }

    /**
     * Realiza el alquiler de una reserva.
     *
     * @param Cliente $cliente Cliente que alquila
     * @param User $usuario Usuario asociado
     * @return bool
     */
    public function alquilar(Cliente $cliente, User $usuario): bool
    {
        $motivo = 'Pagar un alquiler';
        if ($cliente->pagar($this->calcularMontoRestante(), $motivo)) {
            $this->cambiarEstado(EstadoReserva::ALQUILADA);

            $mensaje = "Su alquiler se ha realizado correctamente.";
            $asunto = "Alquiler realizado";
            $destinatario = $usuario->email;

            /**
             * $mensaje, $asunto HAY QUE FIJARSE QUE PONEMOS
             * ------
             * NO OLVIDARSE DE DESCOMENTAR LA LINEA DEL MAIL PARA QUE SE MANDE
             */

            // Mail::to($destinatario)->send(new MailTextoSimple($mensaje, $asunto));
            $this->save();

            return true;
        } else {
            return false;
        }
    }

    /**
     * Realiza el proceso de reserva para un cliente.
     *
     * @param Cliente $cliente Cliente que realiza la reserva
     * @param User $usuario Usuario asociado
     * @return bool
     */
    public function reservar(Cliente $cliente, User $usuario): bool
    {
        $motivo = 'Pagar una reserva';
        if ($cliente->pagar($this->senia, $motivo)) {
            $this->cambiarEstado(EstadoReserva::ACTIVA);

            $mensaje = "Su reserva se ha realizado correctamente.";
            $asunto = "Reserva realizada";
            $destinatario = $usuario->email;

            /**
             * $mensaje, $asunto HAY QUE FIJARSE QUE PONEMOS
             * ------
             * NO OLVIDARSE DE DESCOMENTAR LA LINEA DEL MAIL PARA QUE SE MANDE
             */

            // Mail::to($destinatario)->send(new MailTextoSimple($mensaje, $asunto));
            $this->save();

            return true;
        }
        return false;
    }

    /**
     * Reasigna la devolución de la reserva a un nuevo cliente y cambia su estado a 'Reasignada'.
     *
     * @param Cliente $cliente_devuelve
     * @return void
     */
    public function reasignarDevolucion(Cliente $cliente_devuelve): void
    {
        $this->id_cliente_devuelve = $cliente_devuelve->id_usuario;
        $this->cambiarEstado(EstadoReserva::REASIGNADA);
        $this->save();
    }

    /**
     * Asigna una nueva bicicleta a la reserva.
     *
     * @param Bicicleta $nueva_bicicleta
     * @return void
     */
    public function asignarNuevaBicicleta(Bicicleta $nueva_bicicleta): void
    {
        $this->id_bicicleta = $nueva_bicicleta->id_bicicleta;
        $this->save();
    }

    /**
     * Cambia el estado de la reserva según el ID de estado proporcionado.
     *
     * @param int $id_estado
     * @return void
     */
    public function cambiarEstado(int $id_estado): void
    {
        $this->id_estado = $id_estado;
    }

    /**
     * Cierra el alquiler, actualizando el estado a 'Finalizada'.
     *
     * @return void
     */
    public function cerrarAlquiler(): void
    {
        $this->cambiarEstado(EstadoReserva::FINALIZADA);

        /**
         * TODO
         * FALTA REALIZAR LA LOGICA DE CERRAR EL ALQUILER Y DESCONTAR PUNTOS
         *
         */

        $this->save();
    }

    /**
     * Calcula el monto restante que debe pagarse.
     *
     * @return float
     */
    public function calcularMontoRestante(): float
    {
        return $this->monto - $this->senia;
    }

    /**
     * Calcula el tiempo de uso en horas.
     *
     * @return int
     */
    public function calcularTiempoUso(): int
    {
        return (int) $this->fecha_hora_retiro->diffInHours($this->fecha_hora_devolucion);
    }

    /**
     * Formatea los datos de la reserva cuando está activa.
     *
     * @return array
     */
    public function formatearDatosActiva(): array
    {
        return [
            'id' => $this->id_reserva,
            'fecha_hora_devolucion' => $this->fecha_hora_devolucion->format('H:i'),
            'fecha_hora_retiro' => $this->fecha_hora_retiro->format('H:i'),
            'bicicleta_patente' => $this->bicicleta->patente,
            'estacion_devolucion_nombre' => $this->estacionDevolucion->nombre,
            'estacion_retiro_nombre' => $this->estacionRetiro->nombre,
            'monto_restante' => $this->calcularMontoRestante(),
            'tiempo_uso' => $this->calcularTiempoUso(),
        ];
    }

    /**
     * Formatea los datos para realizar una reserva.
     *
     * @return array
     */
    public function formatearDatosParaReservar(): array
    {
        return [
            'estacion_devolucion_nombre' => $this->estacionDevolucion->nombre,
            'estacion_retiro_nombre' => $this->estacionRetiro->nombre,
            'horario_retiro' => $this->fecha_hora_retiro->format('H:i'),
            'tiempo_uso' => $this->calcularTiempoUso(),
            'monto_total' => $this->monto,
            'monto_senia' => $this->senia,
        ];
    }

    /**
     * Cancela la reserva, actualizando el estado y devolviendo la seña si es necesario.
     *
     * @return string Mensaje de confirmación
     */
    public function cancelar(): string
    {
        if ($this->id_estado == EstadoReserva::MODIFICADA) {
            $cliente = $this->clienteReservo;
            $motivo = 'Devolución de seña';
            $cliente->agregarSaldo($this->senia, $motivo);
            $mensaje = 'Se canceló su reserva correctamente, se devolvió su saldo correspondiente.';
        } else {
            $mensaje = 'Se canceló su reserva correctamente.';
        }
        $this->cambiarEstado(EstadoReserva::CANCELADA);
        $this->save();
        return $mensaje;
    }

    ///////////////////
    //Modificar Reserva:
    ///////////////////

    /**
     * Obtiene la estación más cercana a la seleccionada en la reserva y su respectiva bicicleta disponible.
     *
     * @param int $estacionId ID de la estación seleccionada
     * @param string $nuevo_horario_retiro Nuevo horario de retiro en formato 'H:i:s'
     * @return array|null
     */
    public static function obtenerNuevaEstacionYBicicleta(int $estacionId, string $nuevo_horario_retiro): ?array
    {
        $estacionSeleccionada = Estacion::find($estacionId);

        if (!$estacionSeleccionada) {
            return null;
        }

        $estaciones = Estacion::where('id_estado', EstadoEstacion::ACTIVA)
            ->where('id_estacion', '!=', $estacionId)
            ->get();

        $distanciaMinima = PHP_FLOAT_MAX;

        foreach ($estaciones as $estacion) {
            $distancia = self::calcularDistancia(
                $estacionSeleccionada->latitud,
                $estacionSeleccionada->longitud,
                $estacion->latitud,
                $estacion->longitud
            );
            $distancias_mas_estaciones[] = [$distancia, $estacion];
        }

        usort($distancias_mas_estaciones, function ($a, $b) {
            return $a[0] <=> $b[0];
        });

        foreach ($distancias_mas_estaciones as $distancia_estacion) {
            if ($distancia_estacion[0] < $distanciaMinima) {
                $bicicleta = $distancia_estacion[1]->getBicicletaDisponibleEnEstaHora($nuevo_horario_retiro);
                if ($bicicleta) {
                    $estacion_y_bicicleta = [
                        'nuevaEstacionId' => $distancia_estacion[1]->id_estacion,
                        'bicicleta' => $bicicleta,
                    ];
                    break;
                }
            }
        }
        return $estacion_y_bicicleta ?? null;
    }

    /**
     * Calcula la distancia entre dos puntos geográficos usando la fórmula de Haversine.
     *
     * @param float $lat1 Latitud del primer punto
     * @param float $lon1 Longitud del primer punto
     * @param float $lat2 Latitud del segundo punto
     * @param float $lon2 Longitud del segundo punto
     * @return float Distancia en kilómetros
     */
    private static function calcularDistancia(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $radioTierra = 6371;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $radioTierra * $c;
    }

    // ------------------
    // DEVOLVER
    // ------------------

    /**
     * Realiza la devolución de la reserva.
     *
     * @param array $danios_objetos Array de objetos de Danio
     * @param array $calificaciones Array de id_tipo_calificacion
     * 
     * @return void
     */
    public function devolver(array $danios_objetos, array $calificaciones): void
    {
        /** @var Estacion $estacion_retiro */
        $estacion_retiro = $this->estacionRetiro;
        $estacion_retiro->generarCalificacion($calificaciones['id_tipo_calificacion_retiro']);

        /** @var Estacion $estacion_devolucion */
        $estacion_devolucion = $this->estacionDevolucion;
        $estacion_devolucion->generarCalificacion($calificaciones['id_tipo_calificacion_devolucion']);
        
        $puntaje_obtenido = PuntajeDevolucion::calcularPuntajeObtenido(Carbon::now(), $this->fecha_hora_devolucion->copy()->addMinutes(15), $danios_objetos);
        
        /** @var Cliente $cliente_reservo */
        $cliente_reservo = $this->clienteReservo;
        $cliente_reservo->actualizarPuntaje($puntaje_obtenido);
        $this->puntaje_obtenido = $puntaje_obtenido;
        if (!$this->bicicleta->estoyDisponible()) {
            $this->bicicleta->habilitar();
        }
        $this->cambiarEstado(EstadoReserva::FINALIZADA);
        $this->save();

    }


    ///////////////////////////////////////////////////////////////////////////////

    // Accesores

    /**
     * Accesor para obtener y parsear la fecha/hora de devolución.
     *
     * @param string $valor
     * @return Carbon
     */
    public function getFechaHoraDevolucionAttribute($valor): Carbon
    {
        return Carbon::parse($valor);
    }

    /**
     * Accesor para obtener y parsear la fecha/hora de retiro.
     *
     * @param string $valor
     * @return Carbon
     */
    public function getFechaHoraRetiroAttribute($valor): Carbon
    {
        return Carbon::parse($valor);
    }

    /**
     * Obtiene el nombre del estado de la reserva.
     *
     * @return string
     */
    public function getNombreEstadoReserva(): string
    {
        return $this->estado->nombre;
    }


    /**
     * Relación con la bicicleta asociada a la reserva.
     *
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bicicleta(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Bicicleta::class, 'id_bicicleta', 'id_bicicleta');
    }

    /**
     * Relación con la estación de retiro asociada.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estacionRetiro(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Estacion::class, 'id_estacion_retiro', 'id_estacion');
    }

    /**
     * Relación con la estación de devolución asociada.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estacionDevolucion(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Estacion::class, 'id_estacion_devolucion', 'id_estacion');
    }

    /**
     * Relación con el estado de la reserva.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estado(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(EstadoReserva::class, 'id_estado', 'id_estado');
    }

    /**
     * Relación con el cliente que realizó la reserva.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clienteReservo(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'id_cliente_reservo', 'id_usuario');
    }

    /**
     * Relación con el cliente que devuelve la bicicleta.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clienteDevuelve(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'id_cliente_devuelve', 'id_usuario');
    }

    /**
     * Relación con las infracciones asociadas a la reserva.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function infracciones(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Infraccion::class, 'id_reserva', 'id_reserva');
    }
}
