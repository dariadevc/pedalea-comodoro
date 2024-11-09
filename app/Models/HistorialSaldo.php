<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialSaldo extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_usuario';
    public $incrementing = false;

    protected $table = 'historiales_saldo';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'fecha_hora',
        'monto',
        'motivo',
    ];

    /**
     * Devuelve el cliente asociado al historial de saldo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cliente(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Define el comportamiento al crear un historial de saldo.
     * Genera automáticamente el id_historial_saldo incrementando el último valor.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function ($historialSaldo) {
            $ultimoHistorialSaldo = HistorialSaldo::where('id_usuario', $historialSaldo->id_usuario)
                ->orderBy('id_historial_saldo', 'desc')
                ->first();

            $historialSaldo->id_historial_saldo = $ultimoHistorialSaldo ? $ultimoHistorialSaldo->id_historial_saldo + 1 : 1;
        });
    }
}
