<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialDanio extends Model
{
    use HasFactory;

    protected $table = 'historiales_danios';
    protected $primaryKey = ['id_bicicleta', 'id_historial_danio'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_bicicleta',
        'fecha_hora'
    ];

    /**
     * Devuelve la bicicleta asociada al historial de daños.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bicicleta(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Bicicleta::class, 'id_bicicleta', 'id_bicicleta');
    }

    /**
     * Devuelve los daños asociados a una entrada del historial de daños.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function danios(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Danio::class, 'danios_por_uso', 'id_historial_danio', 'id_danio')
            ->using(DanioPorUso::class)
            ->withPivot('id_bicicleta');
    }

    /**
     * Define el comportamiento al crear un historial de daños.
     * Genera automáticamente el id_historial_danio incrementando el último valor.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function ($historialDanio) {
            $ultimoHistorialDanio = historialDanio::where('id_bicicleta', $historialDanio->id_bicicleta)
                ->orderBy('id_historial_danio', 'desc')
                ->first();

            $historialDanio->id_historial_danio = $ultimoHistorialDanio ? $ultimoHistorialDanio->id_historial_danio + 1 : 1;
        });
    }
}
