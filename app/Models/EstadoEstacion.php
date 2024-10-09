<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoEstacion extends Model
{
    use HasFactory;

    protected $table = 'estados_estacion';

    protected $fillable = [
        'nombre'
    ];

    // Los atributos que no pueden modificarse
    protected $guarded = [
        'id_estado',
    ];

    public function estacion()
    {
        return $this->hasMany(Estacion::class, 'id_estacion', 'id_estado');
    }
}
