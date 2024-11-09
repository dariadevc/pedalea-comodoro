<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClienteRangoPuntos extends Pivot
{
    use HasFactory;

    protected $table = 'clientes_rangos_puntos';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'id_usuario',
        'id_rango_puntos',
        'multa_hecha_por_dia',
        'suspension_hecha_por_dia',
        'cantidad_veces',
    ];

    /**
     * Evalúa si corresponde aplicar una multa al cliente basado en el puntaje y el rango de puntos.
     *
     * @param int $puntaje 
     * @param RangoPuntos $rango_puntos
     * @return bool
     */
    public function evaluarCorrespondeMulta(int $puntaje, RangoPuntos $rango_puntos): bool
    {
        if ($rango_puntos->dentroDelRango($puntaje)) {
            if (!$this->multa_hecha_por_dia) {
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Evalúa si corresponde aplicar una suspensión al cliente basado en el puntaje y el rango de puntos.
     *
     * @param int $puntaje Puntaje actual del cliente.
     * @param RangoPuntos $rango_puntos
     * @return bool
     */
    public function evaluarCorrespondeSuspension(int $puntaje, RangoPuntos $rango_puntos): bool
    {
        if ($rango_puntos->dentroDelRango($puntaje)) {
            if (!$this->suspension_hecha_por_dia && $rango_puntos->tiempo_suspension_dias != null) {
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Genera una multa para el cliente en base al rango de puntos.
     *
     * @param RangoPuntos $rango_puntos
     * @param Cliente $cliente
     * @return void
     */
    public function generarMulta(RangoPuntos $rango_puntos, Cliente $cliente): void
    {
        $this->activarMultaHechaPorDia();
        $this->actualizarVecesEnRango();
        $monto_multa = $rango_puntos->getMontoMulta();
        $monto_multa = $this->calcularMontoMulta($monto_multa);
        $multa = Multa::crearMulta($cliente->id_usuario, $monto_multa);
        $multa->generarDescripcion($cliente->puntaje);
        $multa->guardarMultaCreada();

        $this->guardarClienteRangoPuntos($this);
    }

    /**
     * Genera una suspensión para el cliente en base al rango de puntos.
     *
     * @param RangoPuntos $rango_puntos
     * @param Cliente $cliente
     * @return void
     */
    public function generarSuspension(RangoPuntos $rango_puntos, Cliente $cliente): void
    {
        $this->activarSuspensionHechaPorDia();
        
        $suspension = Suspension::crearSuspension($cliente->id_usuario, $rango_puntos->tiempo_suspension_dias);
        $suspension->generarDescripcion($cliente->puntaje);
        $suspension->guardarSuspensionCreada();

        $this->guardarClienteRangoPuntos($this);
    }

    /**
     * Actualiza la cantidad de veces que el cliente ha estado en el rango de puntos.
     *
     * @return void
     */
    public function actualizarVecesEnRango(): void
    {
        $this->cantidad_veces += 1;
    }

    /**
     * Calcula el monto de la multa en función de la cantidad de veces que el cliente ha estado en el rango.
     *
     * @param float $monto_multa
     * @return float
     */
    public function calcularMontoMulta(float $monto_multa): float
    {
        return $monto_multa * $this->cantidad_veces;
    }

    /**
     * Guarda los cambios realizados para ese cliente y ese rango de puntos en la base de datos.
     *
     * @return void
     */
    public function guardarClienteRangoPuntos(): void
    {
        ClienteRangoPuntos::where('id_usuario', $this->id_usuario)
            ->where('id_rango_puntos', $this->id_rango_puntos)
            ->update([
                'multa_hecha_por_dia' => $this->multa_hecha_por_dia,
                'suspension_hecha_por_dia' => $this->suspension_hecha_por_dia,
                'cantidad_veces' => $this->cantidad_veces,
            ]);
    }

    /**
     * Activa la multa hecha por día.
     *
     * @return void
     */
    public function activarMultaHechaPorDia(): void
    {
        $this->multa_hecha_por_dia = true;
    }

    /**
     * Desactiva la multa hecha por día.
     *
     * @return void
     */
    public function desactivarMultaHechaPorDia(): void
    {
        $this->multa_hecha_por_dia = false;
    }

    /**
     * Activa la suspensión hecha por día.
     *
     * @return void
     */
    public function activarSuspensionHechaPorDia(): void
    {
        $this->suspension_hecha_por_dia = true;
    }

    /**
     * Desactiva la suspensión hecha por día.
     *
     * @return void
     */
    public function desactivarSuspensionHechaPorDia(): void
    {
        $this->suspension_hecha_por_dia = false;
    }

    /**
     * Define la relación de pertenencia con el modelo Cliente.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|App\Models\Cliente
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Define la relación de pertenencia con el modelo RangoPuntos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\App\Models\RangoPuntos
     */
    public function rangoPuntos()
    {
        return $this->belongsTo(RangoPuntos::class, 'id_rango_puntos', 'id_rango_puntos');
    }
}