<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialDanio extends Model
{
    use HasFactory;

    protected $table = 'historial_danio';

    protected $fillable = [
        'id_bicicleta',
        'fecha'
    ];

    protected $guarded = [
        'id_historial_danio',
    ];

    public function bicicleta()
    {
        return $this->belongsTo(Bicicleta::class, 'id_bicicleta');
    }

    //Devuelve los daños asociados a una entrada del historial de daños
    public function danios()
    {
        return $this->belongsToMany(Danio::class, 'danios_por_uso', 'id_historial_danio', 'id_danio')
            ->using(DanioPorUso::class)
            ->withPivot('id_bicicleta');
    }
}
