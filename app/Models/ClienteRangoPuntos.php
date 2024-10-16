<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ClienteRangoPuntos extends Model
{

    use HasFactory;

    protected $table = 'clientes_rangos_puntos';
    // protected $primaryKey = ['id_cliente', 'id_rango_puntos'];
    public $timestamps = false;

    protected $fillable = [
        'multa_hecha_por_dia',
        'suspension_hecha_por_dia',
        'cantidad_veces',
    ];
}
