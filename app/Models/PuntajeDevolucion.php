<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuntajeDevolucion extends Model
{
    use HasFactory;

    protected $table = 'puntajes_devolucion';
    protected $primaryKey = 'id_puntaje_devolucion';
    public $timestamps = false;

    //Atributos modificables:
    protected $fillable = [
        'tope_horario_entrega',
        'puntaje_sin_danio',
        'puntaje_con_danio_recuperable',
        'puntaje_con_danio_no_recuperable',
    ];

    //Atributos no modificables:
    protected $guarded = [
        'id_puntaje_devolucion',
    ];

    public static function calcularPuntajeObtenido(Carbon $horario_actual_devolucion, Carbon $horario_devolucion_reserva, $danios)
    {
        $diferencia_horas = $horario_actual_devolucion->diffInHours($horario_devolucion_reserva, false);
        // $diferencia_horas = $horario_actual_devolucion->addHours(8)->diffInHours($horario_devolucion_reserva, false);
        // $diferencia_horas = $horario_actual_devolucion->addHours(18)->diffInHours($horario_devolucion_reserva, false);
        // $diferencia_horas = $horario_actual_devolucion->addHours(28)->diffInHours($horario_devolucion_reserva, false);
        // $diferencia_horas = $horario_actual_devolucion->addHours(108)->diffInHours($horario_devolucion_reserva, false);
        if ($diferencia_horas > 0) {
            $puntaje = PuntajeDevolucion::where('id_puntaje_devolucion', 1)->first();
        } else {
            $diferencia_horas = (int) abs($diferencia_horas);
            $puntaje = PuntajeDevolucion::where('tope_horario_entrega', '>=', $diferencia_horas)
                ->orderBy('tope_horario_entrega', 'asc')
                ->first();
        }


        if (!empty($danios)) {
            $danios_recuperables = array_filter($danios, fn($danio) => $danio->esRecuperable());
            $danios_no_recuperables = array_filter($danios, fn($danio) => !$danio->esRecuperable());

            if (!empty($danios_no_recuperables)) {
                return $puntaje->puntaje_con_danio_no_recuperable;
            } elseif (!empty($danios_recuperables)) {
                return $puntaje->puntaje_con_danio_recuperable;
            }
        }

        return $puntaje->puntaje_sin_danio;
    }
}
