<?php

namespace App\Models;

use App\Mail\MailTextoSimple;
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
        'seña',
        'puntaje_obtenido',
    ];

    protected $guarded = [
        'id_reserva',
    ];

    public function alquilar($cliente, $usuario) 
    {
        if ($cliente->pagar($this->calcularMontoRestante())) {
            $this->cambiarEstado('Alquilada');

            $mensaje = "Su alquiler se ha realizado correctamente.";
            $asunto = "Alquler realizado";
            $destinatario = $usuario->email;
        
            Mail::to($destinatario)->send(new MailTextoSimple($mensaje, $asunto));
            return true;        
        } else {
            return false;
        }
    }

    function cambiarEstado($nombre_estado) {
        $estado = EstadoReserva::where('nombre', $nombre_estado)->first();
        $this->id_estado = $estado->id_estado;
    }

    public function calcularMontoRestante(): float
    {
        return $this->monto - $this->seña;
    }

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
