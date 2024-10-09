<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estacion extends Model
{
    use HasFactory;

    protected $table = 'estaciones';

    // Los atributos que pueden modificarse
    protected $fillable = [
        'id_estado',
        'nombre',
        'latitud',
        'longitud',
        'calificacion', //Faltaría hacer la conexión con calificaciones para que lo calcule cada vez que se agrega una calificación
    ];

    // Los atributos que no pueden modificarse
    protected $guarded = [
        'id_estacion',
    ];

    // Relación con el estado
    public function estado()
    {
        return $this->belongsTo(EstadoEstacion::class, 'id_estacion');
    }
}
