<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas';

    protected $fillable = [
        'id_bicicleta',
        'id_estacion_retiro',
        'id_estacion_devolucion',
        'id_estado_reserva',
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


    public function bicicleta()
    {
        return $this->belongsTo(Bicicleta::class, 'id_bicicleta');
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
        return $this->belongsTo(EstadoReserva::class, 'id_estado_reserva');
    }

    public function clienteReservo()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente_reservo');
    }

    public function clienteDevuelve()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente_devuelve');
    }
}