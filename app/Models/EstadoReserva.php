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

    
    protected $fillable = [
        'nombre'
    ];

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_estado', 'id_estado');
    }

}

