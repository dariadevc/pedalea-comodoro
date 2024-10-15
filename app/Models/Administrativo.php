<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrativo extends User
{

    use HasFactory;

    protected $table = 'administrativos';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false; // Desactivar marcas de tiempo

    protected $fillable = [
        'id_usuario',
    ];

}
