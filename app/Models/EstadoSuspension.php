<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoSuspension extends Model
{
    use HasFactory;

    protected $table = 'estados_suspension';
    protected $primaryKey = 'id_estado_suspensiones';
    public $timestamps = false;

    // Los atributos que pueden modificarse
    protected $fillable = [
        'nombre',
    ];

    // Los atributos que no pueden modificarse
    protected $guarded = [
        'id_estado_suspensiones',
    ];

    // Relación con el estado
    public function multas()
    {
        return $this->hasMany(Suspension::class, 'id_suspensiones');
    }
}
