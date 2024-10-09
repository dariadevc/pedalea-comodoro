<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCalificacion extends Model
{
    use HasFactory;

    protected $table = 'estaciones';

    // Los atributos que pueden modificarse
    protected $fillable = [
        'cantidad_estrellas',
    ];

    // Los atributos que no pueden modificarse
    protected $guarded = [
        'id_tipo_calificaciones',
    ];

    // Relación con el estado
    public function estado()
    {
        return $this->belongsTo(EstadoEstacion::class, 'id_estacion');
    }
    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class,'id_calificaciones');
    }
}
