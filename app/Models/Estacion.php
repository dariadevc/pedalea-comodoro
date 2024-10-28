<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estacion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'estaciones';
    protected $primaryKey = 'id_estacion';
    public $timestamps = false;

    protected $fillable = [
        'id_estado',
        'nombre',
        'latitud',
        'longitud',
        'calificacion',
    ];

    protected $guarded = [
        'id_estacion',
    ];




    /**
     * FUNCIONES DEL MODELO
     * 
     */
    public function getBicicletaDisponibleAhora(): ?Bicicleta
    {
        return $this->bicicletas()->where('id_estado', 1)
            ->whereDoesntHave('reservas', function ($query) {
                $query->whereIn('id_estado', [1, 2, 5, 6]);
            })->first();
    }
    public function getBicicletaDisponibleEnEstaHora($hora_retiro): ?Bicicleta
    {
        $fecha_hora_retiro = Carbon::today()->setTimeFromTimeString($hora_retiro);
        $fecha_hora_retiro = $fecha_hora_retiro->subMinutes(30);

        $reserva_disponible = $this->reservasDevolucion()
            ->whereIn('id_estado', [1, 2, 5, 6])
            ->where('fecha_hora_devolucion', '<=', $fecha_hora_retiro)
            ->first();

        return $reserva_disponible ? $reserva_disponible->bicicleta : null;
    }

    public function hayDisponibilidadEnEstaHora($hora_retiro): bool
    {
        $fecha_hora_retiro = Carbon::today()->setTimeFromTimeString($hora_retiro);
        $fecha_hora_retiro = $fecha_hora_retiro->subMinutes(30);

        return $this->reservasDevolucion()
            ->whereIn('id_estado', [1, 2, 5, 6])
            ->where('fecha_hora_devolucion', '<=', $fecha_hora_retiro)
            ->exists();
    }

    public function hayDisponibilidadAhora(): bool
    {
        return $this->bicicletas()->where('id_estado', 1)
            ->whereDoesntHave('reservas', function ($query) {
                $query->whereIn('id_estado', [1, 2, 5, 6]);
            })->exists();
    }

    // public function dameReservas($hora_retiro)
    // {
    //     $fecha_hora_retiro = Carbon::today()->setTimeFromTimeString($hora_retiro);
    //     $fecha_hora_retiro = $fecha_hora_retiro->subMinutes(30);

    //     return $this->reservasDevolucion()
    //         ->whereIn('id_estado', [1, 2, 5, 6])
    //         ->where('fecha_hora_devolucion', '<=', $fecha_hora_retiro)
    //         ->get();
    // }


    /**
     * FUNCIONES QUE RELACIONAN A OTROS MODELOS
     * 
     */

    public function estado()
    {
        return $this->belongsTo(EstadoEstacion::class, 'id_estado'); //Acá va la clave foránea
    }


    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class, 'id_estacion', 'id_estacion');
    }

    public function bicicletas()
    {
        return $this->hasMany(Bicicleta::class, 'id_estacion_actual', 'id_estacion');
    }

    public function reservasRetiro()
    {
        return $this->hasMany(Reserva::class, 'id_estacion_retiro', 'id_estacion');
    }

    public function reservasDevolucion()
    {
        return $this->hasMany(Reserva::class, 'id_estacion_devolucion', 'id_estacion');
    }

    public function actualizarPromedio()
    {
        // Calcular el promedio de todas las calificaciones de esta estación
        $promedio = $this->calificaciones()
            ->join('tipos_calificacion', 'calificaciones.id_tipo_calificacion', '=', 'tipos_calificacion.id_tipo_calificacion')
            ->avg('tipos_calificacion.cantidad_estrellas');

        $this->calificacion = $promedio ?? 0;
        $this->save();
    }
}
