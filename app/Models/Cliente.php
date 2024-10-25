<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Cliente extends User
{

    use HasFactory;

    protected $table = 'clientes';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false; // Desactivar marcas de tiempo


    protected $fillable = [
        'id_usuario',
        'id_estado_cliente',
        'puntaje',
        'saldo',
        'fecha_nacimiento',
    ];

    public function obtenerReservaActual(): Reserva
    {
        return $this->reservaReservo->whereIn('id_estado', [1, 5])->first();
    }

    public function pagar($monto) 
    {
        $this->saldo -= $monto;
        $this->save();
    }

    /**
     * ACA VAN FUNCIONES DEL MODELO
     */
    public function estoySuspendido(): bool
    {
        return $this->estadoCliente->nombre == 'Suspendido';
    }

    public function agregarSaldo($monto): void
    {
        $this->saldo += $monto;
        $this->save();
    }
    
    


    /**
     * ACA VAN FUNCIONES QUE RELACIONAN A OTROS MODELOS
     */
    public function estadoCliente()
    {
        return $this->belongsTo(EstadoCliente::class, 'id_estado_cliente');
    }

    public function rangosPuntos()
    {
        return $this->belongsToMany(RangoPuntos::class, 'clientes_rangos_puntos', 'id_usuario', 'id_rango_puntos')
            ->using(ClienteRangoPuntos::class)  // Especifica el modelo de pivote
            ->withPivot('multa_hecha_por_dia', 'suspension_hecha_por_dia', 'cantidad_veces');
    }

    public function historialesSaldo()
    {
        return $this->hasMany(HistorialSaldo::class, 'id_usuario', 'id_usuario');
    }

    public function multas()
    {
        return $this->hasMany(Multa::class, 'id_usuario', 'id_usuario');
    }

    public function reservaReservo()  //Cliente que realizo la reserva
    {
        return $this->hasMany(Reserva::class, 'id_cliente_reservo', 'id_usuario');
    }

    public function reservaDevuelve()//Cliente que puede devolver si se reasigna la devolucion
    {
        return $this->hasMany(Reserva::class, 'id_cliente_devuelve', 'id_usuario');
    }
    
    public function infracciones()
    {
        return $this->hasMany(Infraccion::class, 'id_usuario_cliente', 'id_usuario');
    }
}
