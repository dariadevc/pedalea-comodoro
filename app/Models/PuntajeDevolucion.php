<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuntajeDevolucion extends Model
{
    use HasFactory;

    protected $table = 'puntaje_devolucion';

    //Atributos modificables:
    protected $fillable = [
        'tope_horario_entrega',
        'puntaje',
    ];

    //Atributos no modificables:
    protected $guarded = [
        'id_puntaje_devolucion',
    ];

    //No tiene relaciones 

}
