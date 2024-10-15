<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCalificacion extends Model
{
    use HasFactory;

    protected $table = 'tipos_calificacion';
    protected $primaryKey = 'id_tipo_calificacion';
    public $timestamps = false;

    // Los atributos que no pueden modificarse
    protected $guarded = [
        'cantidad_estrellas',
    ];
    
    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class, 'id_tipo_calificacion', 'id_tipo_calificacion');
    }
}
