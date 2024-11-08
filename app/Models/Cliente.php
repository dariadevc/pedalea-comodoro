<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use PhpParser\Node\Expr\FuncCall;

class Cliente extends Model
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

    public function obtenerReservaActivaModificada(): ?Reserva { 
        return $this->reservaReservo()->whereIn('id_estado', [1, 5])->first(); 
    }

    public function obtenerReservaAlquiladaReasignada(): ?Reserva
    {
        return $this->reservaReservo->whereIn('id_estado', [2, 6])->first();
    }


    public function pagar($monto, $motivo)
    {
        $tarifa = Configuracion::where('clave', 'tarifa')->first();
        $limite_multiplicador_negativo = Configuracion::where('clave', 'limite_multiplicador_negativo')->first();
        $monto_limite_negativo = floatval($tarifa->valor) * floatval($limite_multiplicador_negativo->valor);
        $monto_limite_negativo *= -1;
        if ($this->saldo - $monto < $monto_limite_negativo) {
            return false;
        }
        
        /**
         * TODO
         * FALTA HACER LA LOGICA DEL MONTO NEGATIVO
         * 
         */
        $this->saldo -= $monto;
        $this->save();
        $this->historialesSaldo()->create([
            'monto' => $monto * -1,
            'motivo' => $motivo,
            'fecha_hora' => Carbon::now(),
        ]);
        return true;
    }

    /**
     * ACA VAN FUNCIONES DEL MODELO
     */
    public function estoySuspendido(): bool
    {
        return $this->estadoCliente->nombre == 'Suspendido';
    }

    public function tengoUnaReserva()
    {
        return $this->reservaReservo()->whereIn('id_estado', [1, 2, 5, 6])->exists();
    }

    public function agregarSaldo($monto, $motivo): void
    {
        $this->saldo += $monto;
        $this->save();
        $this->historialesSaldo()->create([
            'monto' => $monto,
            'motivo' => $motivo,
            'fecha_hora' => Carbon::now(),
        ]);
    }

    public function actualizarPuntaje($puntos)
    {
        if ($puntos > 0) {
            $this->agregarPuntos($puntos);
        } else {
            $this->descontarPuntos($puntos);
        }
    }

    public function descontarPuntos($puntos): void
    {
        $this->puntaje += $puntos;
        $this->save();
        $rango_puntos = RangoPuntos::where('rango_minimo', '>=', $this->puntaje)
            ->where('rango_maximo', '<=', $this->puntaje)
            ->first();
        $cliente_rango_puntos = ClienteRangoPuntos::where('id_rango_puntos', $rango_puntos->id_rango_puntos)->where('id_usuario', $this->id_usuario)->first();
        if ($cliente_rango_puntos->id_rango_puntos == 2 && $cliente_rango_puntos->cantidad_veces >= 3) {
            if (!$cliente_rango_puntos->multa_hecha_por_dia) {
                $rango_puntos = RangoPuntos::where('rango_minimo', '>=', $this->puntaje)
                ->where('rango_maximo', '<=', $this->puntaje)
                ->where('id_rango_puntos', '!=', $cliente_rango_puntos->id_rango_puntos)
                ->first();
                $cliente_rango_puntos = ClienteRangoPuntos::where('id_rango_puntos', $rango_puntos->id_rango_puntos)->where('id_usuario', $this->id_usuario)->first();
            }
        }
        if ($cliente_rango_puntos->evaluarCorrespondeMulta($this->puntaje, $rango_puntos)) {
            $cliente_rango_puntos->generarMulta($rango_puntos, $this);
        }
        if ($cliente_rango_puntos->evaluarCorrespondeSuspension($this->puntaje, $rango_puntos)) {
            $cliente_rango_puntos->generarSuspension($rango_puntos, $this);
        }


    }

    public function agregarPuntos($puntos): void
    {
        $this->puntaje += $puntos;
        $this->save();
    }

    public function reiniciarMultasSuspensionHechasPorDia()
    {
        foreach ($this->rangosPuntos as $rango_puntos) {

            if ($rango_puntos->pivot) {
                $rango_puntos->pivot->desactivarMultaHechaPorDia();
                $rango_puntos->pivot->desactivarSuspensionHechaPorDia();
                $rango_puntos->pivot->save();
            }
        }
    }

    public function cambiarEstado($nombre_estado)
    {
        $estado = EstadoCliente::where('nombre', $nombre_estado)->first();
        $this->id_estado_cliente = $estado->id_estado;
        $this->save();
    }

    /**
     * ACA VAN FUNCIONES QUE RELACIONAN A OTROS MODELOS
     */
    public function estadoCliente()
    {
        return $this->belongsTo(EstadoCliente::class, 'id_estado_cliente', 'id_estado');
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

    public function suspensiones()
    {
        return $this->hasMany(Suspension::class, 'id_usuario', 'id_usuario');
    }

    public function reservaReservo()  //Cliente que realizo la reserva
    {
        return $this->hasMany(Reserva::class, 'id_cliente_reservo', 'id_usuario');
    }

    public function reservaDevuelve() //Cliente que puede devolver si se reasigna la devolucion
    {
        return $this->hasMany(Reserva::class, 'id_cliente_devuelve', 'id_usuario');
    }

    public function infracciones()
    {
        return $this->hasMany(Infraccion::class, 'id_usuario_cliente', 'id_usuario');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }
}
