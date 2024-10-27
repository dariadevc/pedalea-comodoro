<?php

namespace App\Models;

use App\Mail\MailTextoSimple;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

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
        return $this->monto - $this->seña;
    }

    public function calcularTiempoUso(): int
    {
        return (int) $this->fecha_hora_retiro->diffInHours($this->fecha_hora_devolucion);
    }

    public function formatearDatosActiva(): array
    {
        return [
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
