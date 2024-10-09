<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RangoPuntos extends Model
{

    use HasFactory;

    protected $table = 'rango_puntos';
    public $timestamps = false; // Desactivar marcas de tiempo

    protected $fillable = [
        'rango_minimo',
        'rango_maximo',
        'monto_multa',
        'tiempo_suspension_dias',
    ];

    protected $guarded = [
        'id_rango_puntos',
    ];

    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'clientes_rangos_puntos', 'id_rango_puntos', 'id_usuario')
                    ->using(ClienteRangoPuntos::class)  // Especifica el modelo de pivote
                    ->withPivot('multa_hecha_por_dia', 'suspension_hecha_por_dia', 'cantidad_veces');
    }

}
