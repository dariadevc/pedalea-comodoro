<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoReserva extends Model
{
    use HasFactory;

    protected $table = 'estados_reserva';

    protected $fillable = ['nombre',
    ];

    protected $guarded = [
        'id_estado_reserva',
    ];

    public function reserva()
    {
        return $this->hasMany(Reserva::class, 'id_estado_reserva');
    }

}

