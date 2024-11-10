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

    protected $fillable = [
        'id_tipo_danio',
        'descripcion',
    ];

    /**
     * Verifica si el tipo de danio es recuperable.
     *
     * @return bool
     */
    public function esRecuperable(): bool
    {
        return $this->id_tipo_danio == TipoDanio::RECUPERABLE;
    }

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
