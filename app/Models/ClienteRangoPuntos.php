<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;
use Laravel\Telescope\Telescope;

class ClienteRangoPuntos extends Pivot
{

    use HasFactory;

    protected $table = 'clientes_rangos_puntos';
    // protected $primaryKey = ['id_cliente', 'id_rango_puntos'];
    public $timestamps = false;

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

    public function evaluarCorrespondeMulta($puntaje)
    {
        if ($this->rangoPuntos->dentroDelRango($puntaje)) {
            if (!$this->multa_hecha_por_dia) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function evaluarCorrespondeSuspension($puntaje)
    {
        if ($this->rangoPuntos->dentroDelRango($puntaje)) {
            Log::info('cantidad de veces:', $this->cantidad_veces , $this->rangoPuntos->id_rango_puntos );
            Telescope::recordDump( $this->cantidad_veces , $this->rangoPuntos->id_rango_puntos );
            Telescope::recordDump( dump($this->cantidad_veces , $this->rangoPuntos->id_rango_puntos) );
            if ($this->rangoPuntos->id_rango_puntos == 2 && $this->cantidad_veces > 3) {
                return false;
            }
            if ($this->suspension_hecha_por_dia) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function generarMulta()
    {
        $this->activarMultaHechaPorDia();
        $this->actualizarVecesEnRango();
        $monto_multa = $this->rangoPuntos->getMontoMulta();
        $monto_multa = $this->calcularMontoMulta($monto_multa);
        $multa = Multa::crearMulta($this->cliente->id_usuario, $monto_multa);
        $multa->generarDescripcion($this->cliente->puntaje);
        $multa->guardarMultaCreada();
        
        $this->save();
    }

    public function actualizarVecesEnRango()
    {
        $this->cantidad_veces += 1;
    }
    
    public function calcularMontoMulta($monto_multa)
    {
        return $monto_multa * $this->cantidad_veces;
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
