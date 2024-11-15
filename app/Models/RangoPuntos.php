<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RangoPuntos extends Model
{
    use HasFactory;

    protected $table = 'rangos_puntos';
    protected $primaryKey = 'id_rango_puntos';
    public $timestamps = false;

    protected $fillable = [
        'rango_minimo',
        'rango_maximo',
        'monto_multa',
        'tiempo_suspension_dias',
    ];

    protected $guarded = [
        'id_rango_puntos',
    ];

    /**
     * Verifica si un puntaje dado se encuentra dentro del rango.
     *
     * @param int $puntaje
     * @return bool
     */
    public function dentroDelRango(int $puntaje): bool
    {
        return ($this->rango_minimo >= $puntaje && $puntaje >= $this->rango_maximo);
    }

    /**
     * Obtiene el monto de la multa para el rango de puntos.
     *
     * @return float
     */
    public function getMontoMulta(): float
    {
        return $this->monto_multa;
    }

    /**
     * Define la relación de muchos a muchos con los clientes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clientes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Cliente::class, 'clientes_rangos_puntos', 'id_rango_puntos', 'id_usuario')
                    ->using(ClienteRangoPuntos::class)  // Especifica el modelo de pivote
                    ->withPivot('multa_hecha_por_dia', 'suspension_hecha_por_dia', 'cantidad_veces');
    }
}
