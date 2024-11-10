<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Bicicleta extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'bicicletas';
    protected $primaryKey = 'id_bicicleta';
    public $timestamps = false;

    protected $fillable = [
        'id_estado',
        'id_estacion_actual',
        'patente',
    ];


    protected $guarded = [
        'id_bicicleta',
    ];


    /**
     * Editar el estado y la estación actual.
     * 
     * @param int $id_estado
     * @param int $id_estacion
     * 
     * @return void
     */
    public function editar(int $id_estado, int $id_estacion_actual): void
    {
        $this->id_estado = $id_estado;
        $this->id_estacion_actual = $id_estacion_actual;
        $this->save();
    }

    /**
     * Verifica si la bicicleta esta en un alquiler.
     * 
     * @return bool
     */
    public function estoyEnUnAlquiler(): bool
    {
        return $this->reservas()->whereIn('id_estado', [EstadoReserva::ALQUILADA, EstadoReserva::REASIGNADA])->exists();
    }
    
    /**
     * Obtiene el alquiler actual de la bicicleta, si no existe devuelve null.
     *
     * @return \App\Models\Reserva|null
     */
    public function getAlquilerActual(): ?Reserva
    {
        return $this->reservas()->whereIn('id_estado', [EstadoReserva::ALQUILADA, EstadoReserva::REASIGNADA])->first();
    }
    
    
    /**
     * Establece el comportamiento de eventos del modelo al inicializarse.
     *
     * Este método se ejecuta automáticamente cuando el modelo es "booted" y
     * define un evento `creating` que asigna la próxima patente a la bicicleta
     * antes de que se cree en la base de datos.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function ($bicicleta) {
            $bicicleta->patente = self::generateNextPatente();
        });
    }

    /**
     * Genera la siguiente patente secuencial basada en la última patente registrada.
     *
     * @return string
     * @throws \Exception
     */
    public static function generateNextPatente(): string
    {
        return DB::transaction(function () {
            $ultimaPatente = self::orderBy('patente', 'desc')->lockForUpdate()->value('patente'); // Obtener la última patente y bloquear la tabla para lectura y escritura

            if (!$ultimaPatente) {
                return 'A00';
            }

            // Descomponer la última patente
            $letra = substr($ultimaPatente, 0, 1);
            $numero = intval(substr($ultimaPatente, 1, 2));

            if ($numero < 99) {
                $numero++;
            } else {
                $numero = 0;
                if ($letra === 'Z') {
                    throw new \Exception('Se ha alcanzado el límite máximo de patentes.');
                }
                $letra = chr(ord($letra) + 1); // Incrementar la letra
            }

            // Formatear la nueva patente
            return sprintf('%s%02d', $letra, $numero);
        });
    }

    /**
     * Relación con el estado.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\App\Models\EstadoBicicleta
     */
    public function estado()
    {
        return $this->belongsTo(EstadoBicicleta::class, 'id_estado', 'id_estado');
    }

    /**
     * Relación con la estación actual.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\App\Models\Estacion
     */
    public function estacionActual()
    {
        return $this->belongsTo(Estacion::class, 'id_estacion_actual', 'id_estacion');
    }

    /**
     * Relación con los historiales de daños.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Collection<\App\Models\HistorialDanio>
     */
    public function historialesDanios()
    {
        return $this->hasMany(HistorialDanio::class, 'id_bicicleta', 'id_bicicleta');
    }

    /**
     * Relación con las reservas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Collection<\App\Models\Reserva>
     */
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_bicicleta', 'id_bicicleta');
    }


}
