<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Danio extends Model
{
    use HasFactory;

    protected $table = 'danios';
    protected $primaryKey = 'id_danio';
    public $timestamps = false;

    // Los atributos que pueden modificarse
    protected $fillable = [
        'id_tipo_danio',
        'descripcion',
    ];

    /**
     * Define la relación de pertenencia con el modelo TipoDanio.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoDanio(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TipoDanio::class, 'id_tipo_danio', 'id_tipo_danio');
    }

    /**
     * Define la relación de muchos a muchos con el modelo HistorialDanio.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function historialDanio(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(HistorialDanio::class, 'danios_por_uso', 'id_historial_danio', 'id_danio')
            ->using(DanioPorUso::class)
            ->withPivot('id_bicicleta');
    }
}
