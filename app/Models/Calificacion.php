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

    protected $fillable = [
        'id_estacion',
        'id_tipo_calificacion',
    ];


    /**
     * Establece el comportamiento de eventos del modelo al inicializarse.
     * 
     * Este método se ejecuta automáticamente cuando el modelo es "booted" y
     * define un evento `created` que, al crear una nueva calificación, actualiza
     * el promedio de la estación asociada.
     * 
     * @return void
     */
    protected static function booted(): void
    {
        static::created(function ($calificacion) {
            $calificacion->estacion->actualizarPromedio();
        });
    }

    /**
     * Relación con el tipo de calificación.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\App\Models\TipoCalificacion
     */
    public function tipoCalificacion()
    {
        return $this->belongsTo(TipoCalificacion::class, 'id_tipo_calificacion', 'id_tipo_calificacion');
    }

    /**
     * Relación con la estación.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\App\Models\Estacion
     */
    public function estacion()
    {
        return $this->belongsTo(Estacion::class, 'id_estacion', 'id_estacion');
    }
}
