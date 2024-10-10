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

    //TODO: Probar en la BD que calcule bien el promedio.
    // Método para actualizar el promedio de la estación, hay que llamarlo al crear una nueva calificación
    public function actualizarPromedioEstacion()
    {
        // Calcular el promedio de todas las calificaciones de esta estación
        $promedio = Calificacion::where('id_estacion', $this->id)
            ->join('tipo_calificacion', 'calificacion.id_tipo_calificacion', '=', 'tipo_calificacion.id_tipo_calificacion')
            ->avg('tipo_calificacion.cantidad_estrellas');

        // Actualizar la calificación promedio de la estación
        $this->calificacion = $promedio ?? 0;
        $this->save();
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class, 'id_estacion');
    }

    public function bicicleta()
    {
        return $this->hasMany(Bicicleta::class, 'id_estacion');
    }

    public function reservaRetiro()
    {
        return $this->hasMany(Reserva::class, 'id_estacion_retiro');
    }

    public function reservaDevolucion()
    {
        return $this->hasMany(Reserva::class, 'id_estacion_devolucion');
    }
    
}
