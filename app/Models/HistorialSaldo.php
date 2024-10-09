<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialSaldo extends Model
{

    use HasFactory;

    protected $table = 'historiales_saldos';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'fecha_hora',
        'monto',
        'motivo',
    ];
}
