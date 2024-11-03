<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    
    // foreach($cliente->rangosPuntos as $rangoPunto) {
    //     dump($rangoPunto->pivot);
    // }
    // die();

    public function evaluarCorrespondeMultaSuspension($puntaje)
    {
        if ($this->puntaje->dentroDelRango($puntaje)) {

        }
    }

    public function generarMulta()
    {

    }

    public function haGeneradoUnaMulta()
    {

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
