<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteRangoPuntos extends Model
{

    use HasFactory;

    protected $table = 'clientes_rangos_puntos';
    public $timestamps = false; // Desactivar marcas de tiempo

    protected $fillable = [
        'multa_hecha_por_dia',
        'suspension_hecha_por_dia',
        'cantidad_veces',
    ];

    protected $guarded = [
        'id_usuario',
        'id_rango_puntos',
    ];


}
