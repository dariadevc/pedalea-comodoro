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

    // Los atributos que se pueden modificar
    protected $fillable = [
        'nombre'
    ];

    // Los atributos que no pueden modificarse
    protected $guarded = [
        'id_estado',
    ];

    public function bicicleta()
    {
        return $this->hasMany(Bicicleta::class, 'id_bicicleta', 'id_estado');
    }
}
