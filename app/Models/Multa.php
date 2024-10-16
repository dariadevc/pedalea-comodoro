<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Multa extends Model
{
    use HasFactory;

    protected $table = 'multas';
    protected $primaryKey = 'id_multa';
    public $timestamps = false;

    //Son modificables:
    protected $fillable = [
        'id_usuario',
        'id_estado',
        'monto',
        'fecha_hora',
        'descripcion',
    ];

    //No modificables:
    protected $guarded = [
        'id_multa',
    ];

    //Una multa tiene un estado de multa:
    public function estado()
    {
        return $this->belongsTo(EstadoMulta::class, 'id_estado', 'id_estado');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_usuario', 'id_usuario');
    }


}
