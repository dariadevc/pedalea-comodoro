<?php

namespace App\Models;

use Carbon\Carbon;
use App\Mail\MailTextoSimple;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
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
     * FUNCIONES DEL MODELO
     *
     */

    // TODO: Modificar para que funcione con el modelo de EstadoReserva
    public function estoyReservada()
    {
        return in_array($this->id_estado, [1, 5]); //Estado = Alquilada o Modificada
    }
    public function estoyAlquilada()
    {
        return in_array($this->id_estado, [2, 6]); //Estado = Alquilada o Reasignada
    }

    public function estoyReasignada()
    {
        return $this->id_estado == 6;
    }

    public static function crearReserva($horario_retiro, $tiempo_uso, $id_estacion_devolucion, $id_estacion_retiro, $id_cliente_reservo)
    {
        $tiempo_uso = (int) $tiempo_uso;
        $id_estacion_devolucion = (int) $id_estacion_devolucion;
        $id_estacion_retiro = (int) $id_estacion_retiro;
        $id_cliente_reservo = (int) $id_cliente_reservo;
        $tarifa = Configuracion::where('clave', 'tarifa')->first();
        $fecha_hora_retiro = Carbon::today()->setTimeFromTimeString($horario_retiro);
        $fecha_hora_devolucion = (clone $fecha_hora_retiro)->addHours($tiempo_uso);
        $id_estado = null; // Es null porque todavia no se pago la reserva
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

    public function alquilar($cliente, $usuario)
    {
        if ($cliente->pagar($this->calcularMontoRestante())) {
            $this->cambiarEstado('Alquilada');

            $mensaje = "Su alquiler se ha realizado correctamente.";
            $asunto = "Alquler realizado";
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

    public function reservar($cliente, $usuario)
    {
        if ($cliente->pagar($this->senia)) {
            $this->cambiarEstado('Activa');

            $mensaje = "Su reserva se ha realizado correctamente.";
            $asunto = "Reserva realizada";
            $destinatario = $usuario->email;

            /**
             * $mensaje, $asunto HAY QUE FIJARSE QUE PONEMOS
             * ------
             *  * NO OLVIDARSE DE DESCOMENTAR LA LINEA DEL MAIL PARA QUE SE MANDE
             */

            // Mail::to($destinatario)->send(new MailTextoSimple($mensaje, $asunto));
            $this->save();

            return true;
        } else {
            return false;
        }
    }

    // Método que setea el id del cliente que devuelve al reasignar la devolución y cambia el estado de la reserva a reasignada
    public function reasignarDevolucion($usuario_devuelve)
    {
        $this->id_cliente_devuelve = $usuario_devuelve->id_usuario;
        $this->cambiarEstado('Reasignada');
        $this->save();
    }

    public function asignarNuevaBicicleta($nueva_bicicleta): void
    {
        $this->id_bicicleta = $nueva_bicicleta->id_bicicleta;
        $this->save();
    }


    public function cambiarEstado($nombre_estado)
    {
        $estado = EstadoReserva::where('nombre', $nombre_estado)->first();
        $this->id_estado = $estado->id_estado;
    }

    public function cerrarAlquiler(): void
    {
        $this->cambiarEstado('Finalizada');

        /**
         * TODO
         * FALTA REALIZAR LA LOGICA DE CERRAR EL ALQUILER Y DESCONTAR PUNTOS
         *
         */

        $this->save();
    }

    public function calcularMontoRestante(): float
    {
        return $this->monto - $this->senia;
    }

    public function calcularTiempoUso(): int
    {
        return (int) $this->fecha_hora_retiro->diffInHours($this->fecha_hora_devolucion);
    }

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

    public function cancelar(){
        if($this->id_estado == 5){
            $cliente = $this->clienteReservo;
            $cliente->agregarSaldo($this->senia);
            $mensaje = 'Se canceló su reserva correctamente, se devolvió su saldo correspondiente.';
        } else {
            $mensaje = 'Se canceló su reserva correctamente.';
        }
        $this->id_estado= 4;
        $this->save();
        return $mensaje;
    }

    ///////////////////
    //Modificar Reserva:
    ///////////////////

    //Metodo para obtener la estacion mas cercana a la que selecciono en la reserva y su respectiva bicicleta.
    public static function obtenerNuevaEstacionYBicicleta($estacionId)
    {
        $estacionSeleccionada = Estacion::find($estacionId);

        if (!$estacionSeleccionada) {
            return null;
        }

        //Se obtienen las estaciones activas con sus respectiva long y lat.
        $estaciones = Estacion::where('id_estado', 1)
                            ->where('id_estacion', '!=', $estacionId)
                            ->get(['id_estacion', 'latitud', 'longitud']);

        // Variable para almacenar la estación más cercana y la distancia mínima
        $estacionMasCercana = null;
        $distanciaMinima = PHP_FLOAT_MAX;

        foreach ($estaciones as $estacion) {
            $distancia = self::calcularDistancia(
                $estacionSeleccionada->latitud,
                $estacionSeleccionada->longitud,
                $estacion->latitud,
                $estacion->longitud
            );

            if ($distancia < $distanciaMinima) {
                $bicicletaDisponible = Bicicleta::where('id_estacion_actual', $estacion->id_estacion)
                                                ->first();

                if ($bicicletaDisponible) {
                    $distanciaMinima = $distancia;
                    $estacionMasCercana = [
                        'nuevaEstacionId' => $estacion->id_estacion,
                        'bicicleta' => $bicicletaDisponible,
                    ];
                }
            }
        }
        return $estacionMasCercana;
    }

    private static function calcularDistancia($lat1, $lon1, $lat2, $lon2)
    {
        $radioTierra = 6371;

        //Convierte los valores en radianes:
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        //Formula Haversine(Distancia entre un punto y otro).
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);

        //Arco de distancia en radianes:
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        //Convertir la distancia de radianes a kilometros:
        $distancia = $radioTierra * $c;

        return $distancia;
    }
///////////////////////////////////////////////////////////////////////////////

    /**
     * ACCESORES
     */

    public function getFechaHoraDevolucionAttribute($valor): Carbon
    {
        return Carbon::parse($valor);
    }

    public function getFechaHoraRetiroAttribute($valor): Carbon
    {
        return Carbon::parse($valor);
    }

    public function getEstadoReserva(): string
    {
        return $this->estado->nombre;
    }

    public function getClienteDevuelve()
    {
        return $this->id_cliente_devuelve;
    }


    /**
     *
     * FUNCIONES QUE RELACIONAN A OTROS MODELOS
     *
     */

    public function bicicleta()
    {
        return $this->belongsTo(Bicicleta::class, 'id_bicicleta', 'id_bicicleta');
    }

    public function estacionRetiro()
    {
        return $this->belongsTo(Estacion::class, 'id_estacion_retiro');
    }

    public function estacionDevolucion()
    {
        return $this->belongsTo(Estacion::class, 'id_estacion_devolucion');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoReserva::class, 'id_estado', 'id_estado');
    }

    public function clienteReservo()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente_reservo', 'id_usuario');
    }

    public function clienteDevuelve()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente_devuelve', 'id_usuario');
    }

    public function infracciones()
    {
        return $this->hasMany(Infraccion::class, 'id_reserva', 'id_reserva');
    }
}
