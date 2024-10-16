<?php

namespace App\Models;

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

    //No tiene relaciones 

}
