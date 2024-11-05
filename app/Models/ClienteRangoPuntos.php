<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;
use Laravel\Telescope\Telescope;
use phpDocumentor\Reflection\Types\Self_;

class ClienteRangoPuntos extends Pivot
{

    use HasFactory;

    protected $table = 'clientes_rangos_puntos';
    // protected $primaryKey = ['id_usuario', 'id_rango_puntos'];
    public $timestamps = false;
    public $incrementing = false;


    protected $fillable = [
        'id_usuario',
        'id_rango_puntos',
        'multa_hecha_por_dia',
        'suspension_hecha_por_dia',
        'cantidad_veces',
    ];

    public function obtenerObjetos()
    {
        $objetos = [];
        $objetos[] = $this->cliente();
        $objetos[] = $this->rangoPuntos();
        return $objetos;
    }

    public function evaluarCorrespondeMulta($puntaje, $rango_puntos)
    {
        if ($rango_puntos->dentroDelRango($puntaje)) {
            if (!$this->multa_hecha_por_dia) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function evaluarCorrespondeSuspension($puntaje, $rango_puntos)
    {
        if ($rango_puntos->dentroDelRango($puntaje)) {
            if (!$this->suspension_hecha_por_dia && $rango_puntos->tiempo_suspension_dias != null) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function generarMulta($rango_puntos, $cliente)
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

    public function generarSuspension($rango_puntos, $cliente)
    {
        $this->activarSuspensionHechaPorDia();
        
        $suspension = Suspension::crearSuspension($cliente->id_usuario, $rango_puntos->tiempo_suspension_dias);
        $suspension->generarDescripcion($cliente->puntaje);
        $suspension->guardarSuspensionCreada();

        $this->guardarClienteRangoPuntos($this);
    }

    public function actualizarVecesEnRango()
    {
        $this->cantidad_veces += 1;
    }

    public function calcularMontoMulta($monto_multa)
    {
        return $monto_multa * $this->cantidad_veces;
    }


    private function guardarClienteRangoPuntos($cliente_rango_puntos)
    {
        ClienteRangoPuntos::where('id_usuario', $cliente_rango_puntos->id_usuario)
            ->where('id_rango_puntos', $cliente_rango_puntos->id_rango_puntos)
            ->update([
                'multa_hecha_por_dia' => $cliente_rango_puntos->multa_hecha_por_dia,
                'suspension_hecha_por_dia' => $cliente_rango_puntos->suspension_hecha_por_dia,
                'cantidad_veces' => $cliente_rango_puntos->cantidad_veces,
            ]);
    }

    public function activarMultaHechaPorDia()
    {
        $this->multa_hecha_por_dia = true;
    }
    public function desactivarMultaHechaPorDia()
    {
        $this->multa_hecha_por_dia = false;
    }
    public function activarSuspensionHechaPorDia()
    {
        $this->suspension_hecha_por_dia = true;
    }
    public function desactivarSuspensionHechaPorDia()
    {
        $this->suspension_hecha_por_dia = false;
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_usuario', 'id_usuario');
    }

    public function rangoPuntos()
    {
        return $this->belongsTo(RangoPuntos::class, 'id_rango_puntos', 'id_rango_puntos');
    }
}
