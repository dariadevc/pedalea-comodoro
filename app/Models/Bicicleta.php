<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Bicicleta extends Model
{
    use HasFactory;

    protected $table = 'bicicletas';
    protected $primaryKey = 'id_bicicleta';
    public $timestamps = false;

    // bicicleta

    // Los atributos que pueden modificarse
    protected $fillable = [
        'id_estado',
        'id_estacion_actual',
        'patente',
    ];

    // Los atributos que no pueden modificarse
    protected $guarded = [
        'id_bicicleta',
    ];

    // Relación con el estado
    public function estado()
    {
        return $this->belongsTo(EstadoBicicleta::class, 'id_estado');
    }

    //Relación con la estación actual
    public function estacionActual()
    {
        return $this->belongsTo(Estacion::class, 'id_estacion_actual');
    }

    //Relación con la entidad débil historial_danio
    public function historialesDanios()
    {
        return $this->hasMany(HistorialDanio::class, 'id_bicicleta', 'id_bicicleta');
    }

    public function reserva()
    {
        return $this->hasMany(Reserva::class, 'id_bicicleta');
    }


    protected static function booted()
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
    public static function generateNextPatente()
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
}
