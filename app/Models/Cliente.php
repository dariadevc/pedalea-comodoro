<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log as FacadesLog;

class Cliente extends Model
{

    use HasFactory;

    protected $table = 'clientes';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;
    public $incrementing = false;


    protected $fillable = [
        'id_usuario',
        'id_estado_cliente',
        'puntaje',
        'saldo',
        'fecha_nacimiento',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ]; 

    /**
     * Obtener una reserva activa o modificada, si no existe devuelve null.
     * 
     * @return \App\Models\Reserva|null
     */
    public function obtenerReservaActivaModificada(): ?Reserva
    {
        return $this->reservaReservo()->whereIn('id_estado', [EstadoReserva::ACTIVA, EstadoReserva::MODIFICADA])->first();
    }

    /**
     * Obtener una reserva alquilada o reasignada, si no existe devuelve null.
     * 
     * @return \App\Models\Reserva|null
     */
    public function obtenerReservaAlquiladaReasignada(): ?Reserva
    {
        return $this->reservaReservo->whereIn('id_estado', [EstadoReserva::ALQUILADA, EstadoReserva::REASIGNADA])->first();
    }

    /**
     * Obtener una reserva alquilada, si no existe devuelve null.
     * 
     * @return \App\Models\Reserva|null
     */
    public function obtenerReservaAlquilada(): ?Reserva
    {
        return $this->reservaReservo->where('id_estado', EstadoReserva::ALQUILADA)->first();
    }

    public function obtenerReserva()
    {
        return $this->reservaReservo->whereIn('id_estado', [EstadoReserva::ACTIVA, EstadoReserva::MODIFICADA, EstadoReserva::ALQUILADA, EstadoReserva::REASIGNADA])->first();
    }

    /**
     * Obtener la última reserva del cliente.
     * 
     * @return \App\Models\Reserva|null
     */
    public function obtenerUltimaReserva(): ?Reserva
    {
        return $this->reservaReservo()->orderBy('created_at', 'desc')->first();
    }

    /**
     * Pagar con el saldo del cliente.
     * 
     * Si el saldo negativo supera el límite, devuelve false.
     * 
     * @param float $monto
     * @param string $motivo
     * 
     * @return bool
     */
    public function pagar(float $monto, string $motivo): bool
    {
        $tarifa = Configuracion::where('clave', 'tarifa')->first();
        $limite_multiplicador_negativo = Configuracion::where('clave', 'limite_multiplicador_negativo')->first();
        $monto_limite_negativo = floatval($tarifa->valor) * floatval($limite_multiplicador_negativo->valor);
        $monto_limite_negativo *= -1;
        FacadesLog::info($this->saldo);
        FacadesLog::info($monto);
        FacadesLog::info($monto_limite_negativo);
        if ($this->saldo - $monto < $monto_limite_negativo) {
            FacadesLog::info('entro por aca');
            return false;
        }
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
     * Verifica si esta suspendido en el sistema.
     * 
     * @return bool
     */
    public function estoySuspendido(): bool
    {
        return $this->id_estado_cliente == EstadoCliente::SUSPENDIDO;
    }


    /**
     * Verifica si tiene una reserva.
     * 
     * Puede ser una reserva activa, modificada, alquilada o reasignada.
     * 
     * @return bool
     */
    public function tengoUnaReserva(): bool
    {
        return $this->reservaReservo()->whereIn('id_estado', [
            EstadoReserva::ACTIVA,
            EstadoReserva::ALQUILADA,
            EstadoReserva::MODIFICADA,
            EstadoReserva::REASIGNADA,
        ])->exists();
    }

    /**
     * Agrega saldo al cliente y almacena el historial de saldo correspondiente.
     * 
     * 
     * @param int $monto
     * @param string $motivo
     *
     * @return void
     */
    public function agregarSaldo(int $monto, string $motivo): void
    {
        $this->saldo += $monto;
        $this->save();
        $this->historialesSaldo()->create([
            'monto' => $monto,
            'motivo' => $motivo,
            'fecha_hora' => Carbon::now(),
        ]);
    }

    /**
     * Actualiza el puntaje del cliente.
     * 
     * 
     * @param int $puntos Puede ser negativo o positivo
     * 
     * @return void
     */
    public function actualizarPuntaje(int $puntos)
    {
        if ($puntos > 0) {
            $this->agregarPuntos($puntos);
        } else {
            $this->descontarPuntos($puntos);
        }
    }

    /**
     * Descuenta puntos al cliente.
     * 
     * Si el puntaje del cliente es menor a 0, evalúa si le corresponde una multa o una
     * suspension. Si le corresponde le genera una multa o una suspension.
     * 
     * @param int $puntos
     * 
     * @return void
     */
    public function descontarPuntos(int $puntos): void
    {
        $this->puntaje += $puntos;
        $this->save();

        if ($this->puntaje < 0) {
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
    }

    /**
     * Agrega puntos al cliente.
     * 
     * @param int $puntos
     * 
     * @return void
     */
    public function agregarPuntos(int $puntos): void
    {
        $this->puntaje += $puntos;
        $this->save();
    }



    /**
     * Cambia el estado del cliente.
     * 
     * @param int $id_estado
     * 
     * @return void
     */
    public function cambiarEstado(int $id_estado): void
    {
        $this->id_estado_cliente = $id_estado;
        $this->save();
    }

    public function crearRangosPuntos()
    {
        $clientes_rangos_puntos = [];
        $id_rangos_puntos = RangoPuntos::pluck('id_rango_puntos')->toArray();

        foreach ($id_rangos_puntos as $id_rango_puntos) {
            if ($id_rango_puntos == 3) {
                $clientes_rangos_puntos[] = [
                    'id_usuario' => $this->id_usuario,
                    'id_rango_puntos' => $id_rango_puntos,
                    'multa_hecha_por_dia' => false,
                    'suspension_hecha_por_dia' => false,
                    'cantidad_veces' => 3,
                ];
            } else {
                $clientes_rangos_puntos[] = [
                    'id_usuario' => $this->id_usuario,
                    'id_rango_puntos' => $id_rango_puntos,
                    'multa_hecha_por_dia' => false,
                    'suspension_hecha_por_dia' => false,
                    'cantidad_veces' => 0,
                ];
            }
        }
        ClienteRangoPuntos::insert($clientes_rangos_puntos);
    }


    /**
     * Relación con el estado del cliente.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\App\Models\EstadoCliente
     */
    public function estadoCliente()
    {
        return $this->belongsTo(EstadoCliente::class, 'id_estado_cliente', 'id_estado');
    }

    /**
     * Relación con los rangos de puntos.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\ManyToMany|\Illuminate\Database\Eloquent\Collection<\App\Models\RangoPuntos>
     */
    public function rangosPuntos()
    {
        return $this->belongsToMany(RangoPuntos::class, 'clientes_rangos_puntos', 'id_usuario', 'id_rango_puntos')
            ->using(ClienteRangoPuntos::class)  // Especifica el modelo de pivote
            ->withPivot('multa_hecha_por_dia', 'suspension_hecha_por_dia', 'cantidad_veces');
    }


    /**
     * Relación con los historiales de saldo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Collection<\App\Models\HistorialSaldo>
     */
    public function historialesSaldo()
    {
        return $this->hasMany(HistorialSaldo::class, 'id_usuario', 'id_usuario');
    }


    /**
     * Relación con las multas.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Collection<\App\Models\Multa>
     */
    public function multas()
    {
        return $this->hasMany(Multa::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Relación con las suspensiones.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Collection<\App\Models\Suspension>
     */
    public function suspensiones()
    {
        return $this->hasMany(Suspension::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Relación con las reservas donde el cliente reserva.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Collection<\App\Models\Reserva>
     */
    public function reservaReservo()
    {
        return $this->hasMany(Reserva::class, 'id_cliente_reservo', 'id_usuario');
    }


    /**
     * Relación con las reservas donde el cliente devuelve.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Collection<\App\Models\Reserva>
     */
    public function reservaDevuelve()
    {
        return $this->hasMany(Reserva::class, 'id_cliente_devuelve', 'id_usuario');
    }


    /**
     * Relación con las infracciones.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Collection<\App\Models\Infraccion>
     */
    public function infracciones()
    {
        return $this->hasMany(Infraccion::class, 'id_usuario_cliente', 'id_usuario');
    }

    /**
     * Relación con el usuario.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\App\Models\User
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }
}
