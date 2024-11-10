<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Infraccion extends Model
{
    use HasFactory;

    protected $table = 'infracciones';
    protected $primaryKey = 'id_infraccion';
    public $timestamps = false;

    protected $fillable = [
        'id_reserva',
        'id_usuario_cliente',
        'id_usuario_inspector',
        'cantidad_puntos',
        'motivo',
    ];

    /**
     * Devuelve la reserva asociada a la infracción.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reserva(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Reserva::class, 'id_reserva', 'id_reserva');
    }

    /**
     * Devuelve el cliente asociado a la infracción.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cliente(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'id_usuario_cliente', 'id_usuario');
    }

    /**
     * Devuelve el inspector asociado a la infracción.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function inspector(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Inspector::class, 'id_usuario_inspector', 'id_usuario');
    }
}
