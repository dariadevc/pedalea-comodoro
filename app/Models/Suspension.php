<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suspension extends Model
{
    use HasFactory;
    
    protected $table = 'suspensiones';

    // Los atributos que pueden modificarse
    protected $fillable = [
        'id_usuario',
        'fecha_desde',
        'fecha_hasta',
        'descripcion',
    ];

    // Los atributos que no pueden modificarse
    protected $guarded = [
        'id_suspensiones',
    ];

    // Relación con el estado
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
    public function estadoSuspension()
    {
        return $this->belongsTo(EstadoSuspension::class, 'id_estado_suspensiones');
    }
}
