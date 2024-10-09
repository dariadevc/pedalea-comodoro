<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialSaldo extends Model
{

    use HasFactory;

    protected $primaryKey = ['id_usuario', 'id_historial_saldo'];
    public $incrementing = false;

    protected $table = 'historiales_saldo';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'fecha_hora',
        'monto',
        'motivo',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_usuario');
    }

    // Generar dependiente_id automáticamente
    protected static function booted()
    {
        static::creating(function ($historialSaldo) {
            $ultimoHistorialSaldo = HistorialSaldo::where('id_usuario', $historialSaldo->id_usuario)
                ->orderBy('id_historial_saldo', 'desc')
                ->first();

            $historialSaldo->id_historial_saldo = $ultimoHistorialSaldo ? $ultimoHistorialSaldo->id_historial_saldo + 1 : 1;
        });
    }
}
