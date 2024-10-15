<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    use HasFactory;

    protected $table = 'calificaciones';
    protected $primaryKey = 'id_calificacion';
    public $timestamps = false;

    // Los atributos que pueden modificarse
    protected $fillable = [
        'id_estacion',
        'id_tipo_calificacion',

    ];

    // Los atributos que no pueden modificarse
    protected $guarded = [
        'id_calificacion',
    ];

    // Evento que se dispara cuando se crea una calificación para actualizar el promedio
    protected static function booted()
    {
        static::created(function ($calificacion) {
            $calificacion->estacion->actualizarPromedio();
        });
    }

    // Relación con el estado
    public function tipoCalificacion()
    {
        return $this->belongsTo(TipoCalificacion::class, 'id_tipo_calificacion', 'id_tipo_calificacion');
    }

    public function estacion()
    {
        return $this->belongsTo(Estacion::class, 'id_estacion', 'id_estacion');
    }
}
