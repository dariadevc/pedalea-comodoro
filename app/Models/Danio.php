<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Danio extends Model
{
    use HasFactory;

    protected $table = 'danios';

    // Los atributos que pueden modificarse
    protected $fillable = [
        'id_tipo_danio',
        'descripcion',
    ];

    // Los atributos que no pueden modificarse
    protected $guarded = [
        'id_danio',
    ];

    public function tipoDanio()
    {
        return $this->belongsTo(TipoDanio::class, 'id_tipo_danio');
    }

    public function historialDanio()
    {
        return $this->belongsToMany(HistorialDanio::class, 'danios_por_uso', 'id_historial_danio', 'id_danio')
            ->using(DanioPorUso::class)
            ->withPivot('id_bicicleta');
    }
}
