<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoMulta extends Model
{
    use HasFactory;

    protected $table = 'estados_multa';
    protected $primaryKey = 'id_estado';
    public $timestamps = false;

    public const PENDIENTE = 1;
    public const PAGADA = 2;

    protected $fillable = [
        'nombre',
    ];


    /**
     * Define la relación de pertenencia con el modelo Multa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function multas()
    {
        return $this->hasMany(Multa::class, 'id_estado', 'id_estado');
    }




}
