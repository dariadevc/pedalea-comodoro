<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoEstacion extends Model
{
    use HasFactory;

    protected $table = 'estados_estacion';
    protected $primaryKey = 'id_estado';
    public $timestamps = false;

    public const ACTIVA = 1;
    public const INACTIVA = 2;

    protected $fillable = [
        'nombre'
    ];


    /**
     * Define la relación de pertenencia con el modelo Estacion.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function estacion()
    {
        return $this->hasMany(Estacion::class, 'id_estacion', 'id_estado');
    }
}
