<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    use HasFactory;

    protected $table = 'estaciones';

    // Los atributos que pueden modificarse
    protected $fillable = [
        'id_estacion',
        'id_tipo_calificaciones',
        
    ];

    // Los atributos que no pueden modificarse
    protected $guarded = [
        'id_calificacion',
    ];

    // Relación con el estado
    public function tipo_calificaciones()
    {
        return $this->belongsTo(TipoCalificacion::class, 'id_tipo_calificaciones');
    }
    public function estacion()
    {
        return $this->belongsTo(Estacion::class, 'id_estacion');
    }
}
