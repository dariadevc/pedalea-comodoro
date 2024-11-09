<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoSuspension extends Model
{
    use HasFactory;

    protected $table = 'estados_suspension';
    protected $primaryKey = 'id_estado';
    public $timestamps = false;

    public const ACTIVA = 1;
    public const FINALIZADA = 2;

    protected $fillable = [
        'nombre',
    ];


    /**
     * Define la relación de pertenencia con el modelo Suspension.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function suspensiones()
    {
        return $this->hasMany(Suspension::class, 'id_estado', 'id_estado');
    }
}
