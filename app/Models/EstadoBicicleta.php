<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoBicicleta extends Model
{
    use HasFactory;

    protected $table = 'estados_bicicleta';
    protected $primaryKey = 'id_estado';
    public $timestamps = false;

    public const DISPONIBLE = 1;
    public const DESHABILITADA = 2;
    
    protected $fillable = [
        'nombre'
    ];

    /**
     * Define la relación de pertenencia con el modelo Bicicleta.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bicicletas()
    {
        return $this->hasMany(Bicicleta::class, 'id_estado', 'id_estado');
    }
}
