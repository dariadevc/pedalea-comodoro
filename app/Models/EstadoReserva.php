<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoReserva extends Model
{
    use HasFactory;

    protected $table = 'estados_reserva';
    protected $primaryKey = 'id_estado';
    public $timestamps = false;

    public const ACTIVA = 1;
    public const ALQUILADA = 2;
    public const FINALIZADA = 3;
    public const CANCELADA = 4;
    public const MODIFICADA = 5;
    public const REASIGNADA = 6;

    protected $fillable = [
        'nombre'
    ];

    /**
     * Define la relación de pertenencia con el modelo Reserva.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_estado', 'id_estado');
    }

}

