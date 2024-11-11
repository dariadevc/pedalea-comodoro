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

    /**
     * Obtiene la primera bicicleta disponible en la estación en este momento.
     *
     * @return Bicicleta|null
     */
    public function getBicicletaDisponibleAhora(): ?Bicicleta
    {
        return $this->bicicletas()->where('id_estado', EstadoBicicleta::DISPONIBLE)
            ->whereDoesntHave('reservas', function ($query) {
                $query->whereIn('id_estado', [EstadoReserva::ACTIVA, EstadoReserva::MODIFICADA, EstadoReserva::ALQUILADA, EstadoReserva::REASIGNADA]);
            })->first();
    }

    /**
     * Obtiene la bicicleta disponible en una hora de retiro específica.
     *
     * @param string $hora_retiro Hora de retiro en formato 'H:i:s'.
     * @return Bicicleta|null
     */
    public function getBicicletaDisponibleEnEstaHora(string $hora_retiro): ?Bicicleta
    {
        $fecha_hora_retiro = Carbon::today()->setTimeFromTimeString($hora_retiro);
        $fecha_hora_retiro = $fecha_hora_retiro->subMinutes(30);

        $reserva_disponible = $this->reservasDevolucion()
            ->whereIn('id_estado', [EstadoReserva::ACTIVA, EstadoReserva::MODIFICADA, EstadoReserva::ALQUILADA, EstadoReserva::REASIGNADA])
            ->where('fecha_hora_devolucion', '<=', $fecha_hora_retiro)
            ->first();
        if ($reserva_disponible) {
            $bicicleta = $reserva_disponible->bicicleta;
        } else {
            $bicicleta = $this->bicicletas()
                ->where('id_estado', EstadoBicicleta::DISPONIBLE)
                ->whereDoesntHave('reservas', function ($query) {
                    $query->whereIn('id_estado', [EstadoReserva::ACTIVA, EstadoReserva::MODIFICADA, EstadoReserva::ALQUILADA, EstadoReserva::REASIGNADA]);
                })->first();
        }

        return $bicicleta;
    }

    /**
     * Verifica si hay bicicletas disponibles en una hora de retiro específica.
     *
     * @param string $hora_retiro Hora de retiro en formato 'H:i:s'.
     * @return bool
     */
    public function hayDisponibilidadEnEstaHora(string $hora_retiro): bool
    {
        $fecha_hora_retiro = Carbon::today()->setTimeFromTimeString($hora_retiro);
        $fecha_hora_retiro = $fecha_hora_retiro->subMinutes(30);

        return $this->reservasDevolucion()
            ->whereIn('id_estado', [EstadoReserva::ACTIVA, EstadoReserva::MODIFICADA, EstadoReserva::ALQUILADA, EstadoReserva::REASIGNADA])
            ->where('fecha_hora_devolucion', '<=', $fecha_hora_retiro)
            ->exists();
    }

    /**
     * Verifica si hay bicicletas disponibles ahora.
     *
     * @return bool
     */
    public function hayDisponibilidadAhora(): bool
    {
        return $this->bicicletas()->where('id_estado', EstadoBicicleta::DISPONIBLE)
            ->whereDoesntHave('reservas', function ($query) {
                $query->whereIn('id_estado', [EstadoReserva::ACTIVA, EstadoReserva::MODIFICADA, EstadoReserva::ALQUILADA, EstadoReserva::REASIGNADA]);
            })->exists();
    }

    /**
     * Genera una nueva calificación para la estación.
     *
     * @param int $id_tipo_calificacion
     * @return void
     */
    public function generarCalificacion(int $id_tipo_calificacion): void
    {
        $this->calificaciones()->create([
            'id_tipo_calificacion' => $id_tipo_calificacion,
        ]);
    }
    
    /**
     * Calcula y actualiza el promedio de todas las calificaciones de la estación.
     *
     * @return void
     */
    public function actualizarPromedio(): void
    {
        $promedio = $this->calificaciones()
            ->join('tipos_calificacion', 'calificaciones.id_tipo_calificacion', '=', 'tipos_calificacion.id_tipo_calificacion')
            ->avg('tipos_calificacion.cantidad_estrellas');

        $this->calificacion = $promedio ?? 0;
        $this->save();
    }


    /**
     * FUNCIONES QUE RELACIONAN A OTROS MODELOS
     * 
     */

    /**
     * Relación con el modelo EstadoEstacion.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo - Relación con el modelo EstadoEstacion.
     */
    public function estado()
    {
        return $this->belongsTo(EstadoEstacion::class, 'id_estado', 'id_estado');
    }

    /**
     * Relación con el modelo Calificacion.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany - Relación con el modelo Calificacion.
     */
    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class, 'id_estacion', 'id_estacion');
    }

    /**
     * Relación con el modelo Bicicleta.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany - Relación con el modelo Bicicleta.
     */
    public function bicicletas()
    {
        return $this->hasMany(Bicicleta::class, 'id_estacion_actual', 'id_estacion');
    }

    /**
     * Relación donde la estación esta como estación de retiro de una reserva.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany - Relación con el modelo Reserva.
     */
    public function reservasRetiro()
    {
        return $this->hasMany(Reserva::class, 'id_estacion_retiro', 'id_estacion');
    }

    /**
     * Relación donde la estación esta como estación de devolución de una reserva.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany - Relación con el modelo Reserva.
     */
    public function reservasDevolucion()
    {
        return $this->hasMany(Reserva::class, 'id_estacion_devolucion', 'id_estacion');
    }

}
