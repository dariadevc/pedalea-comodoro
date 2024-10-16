<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estacion extends Model
{
    use HasFactory;

    protected $table = 'estaciones';
    protected $primaryKey = 'id_estacion';
    public $timestamps = false;

    // Los atributos que pueden modificarse
    protected $fillable = [
        'id_estado',
        'nombre',
        'latitud',
        'longitud',
        'calificacion', //Se calcula cada vez que se agrega una calificación
    ];

    // Los atributos que no pueden modificarse
    protected $guarded = [
        'id_estacion',
    ];

    // Relación con el estado
    public function estado()
    {
        return $this->belongsTo(EstadoEstacion::class, 'id_estado'); //Acá va la clave foránea
    }


    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class, 'id_estacion', 'id_estacion');
    }

    public function bicicleta()
    {
        return $this->hasMany(Bicicleta::class, 'id_estacion_actual', 'id_estacion');
    }

    public function reservaRetiro()
    {
        return $this->hasMany(Reserva::class, 'id_estacion_retiro', 'id_estacion');
    }

    public function reservaDevolucion()
    {
        return $this->hasMany(Reserva::class, 'id_estacion_devolucion', 'id_estacion');
    }

    public function actualizarPromedio()
    {
        // Calcular el promedio de todas las calificaciones de esta estación
        $promedio = $this->calificaciones()  // Usar la relación ya existente
            ->join('tipos_calificacion', 'calificaciones.id_tipo_calificacion', '=', 'tipos_calificacion.id_tipo_calificacion')
            ->avg('tipos_calificacion.cantidad_estrellas');

        // Actualizar la calificación promedio de la estación
        $this->calificacion = $promedio ?? 0;
        $this->save();
    }
}
