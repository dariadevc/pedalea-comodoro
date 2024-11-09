<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DanioPorUso extends Model
{
    use HasFactory;

    protected $table = 'danios_por_uso';
    protected $primaryKey = ['id_bicicleta', 'id_historial_danio', 'id_danio'];
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'id_bicicleta',
        'id_historial_danio',
        'id_danio',
    ];

    //No pongo nada pq se supone que las claves no se deberían modificar, no?s
}
