<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suspension extends Model
{
    use HasFactory;
    
    protected $table = 'suspensiones';
    protected $primaryKey = 'id_suspension';
    public $timestamps = false;

    // Los atributos que pueden modificarse
    protected $fillable = [
        'id_usuario',
        'id_estado',
        'fecha_desde',
        'fecha_hasta',
        'fecha_hora',
        'descripcion',
    ];

    // Los atributos que no pueden modificarse
    protected $guarded = [
        'id_suspension',
    ];

    // Relación con el estado
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }
    public function estadoSuspension()
    {
        return $this->belongsTo(EstadoSuspension::class, 'id_estado', 'id_estado');
    }
}
