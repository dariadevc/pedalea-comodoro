<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Infraccion extends Model
{

    use HasFactory;

    protected $table = 'infracciones';
    protected $primaryKey = 'id_infraccion';
    public $timestamps = false;


    protected $fillable =
    [
        'id_reserva',
        'id_usuario_cliente',
        'id_usuario_inspector',
        'cantidad_puntos',
        'motivo',
    ];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'id_reserva', 'id_reserva');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_usuario_cliente', 'id_usuario');
    }

    public function inspector()
    {
        return $this->belongsTo(Inspector::class, 'id_usuario_inspector', 'id_usuario');
    }

}
