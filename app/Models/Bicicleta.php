<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bicicleta extends Model
{
    use HasFactory;

    // Los atributos que pueden modificarse
    protected $fillable = [
        'id_estado',
        'id_estacion_actual',
        'patente',
    ];

    // Los atributos que no pueden modificarse
    protected $guarded = [
        'id_bicicleta',
    ];

    // Relación con el estado
    public function estado()
    {
        return $this->belongsTo(EstadoBicicleta::class, 'id_estado');
    }

    //Relación con la estación actual
    public function estacionActual()
    {
        return $this->belongsTo(Estacion::class, 'id_estacion_actual');
    }

    //Relación con la entidad débil historial_danio
    public function historialesDanios()
    {
        return $this->hasMany(HistorialDanio::class, 'id_bicicleta');
    }

    public function reserva()
    {
        return $this->hasMany(Reserva::class, 'id_bicicleta');
    }
}
