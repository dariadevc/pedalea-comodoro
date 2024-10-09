<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanioPorUso extends Model
{
    use HasFactory;

    protected $table = 'danios_por_uso';

    //No pongo nada pq se supone que las claves no se deberían modificar, no?s
}
