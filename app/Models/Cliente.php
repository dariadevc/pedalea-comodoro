<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{

    use HasFactory;

    protected $primaryKey = 'id_usuario';
    protected $table = 'clientes';
    public $timestamps = false; // Desactivar marcas de tiempo


    protected $fillable = 
    [
        'id_estado_cliente',
        'puntaje',
        'saldo',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function estadoCliente()
    {
        return $this->belongsTo(EstadoCliente::class, 'id_estado_cliente');
    }

    public function rangosPuntos()
    {
        return $this->belongsToMany(RangoPuntos::class, 'clientes_rangos_puntos', 'id_usuario', 'id_rango_puntos')
            ->using(ClienteRangoPuntos::class)  // Especifica el modelo de pivote
            ->withPivot('multa_hecha_por_dia', 'suspension_hecha_por_dia', 'cantidad_veces');
    }

    public function historialesSaldo()
    {
        return $this->hasMany(HistorialSaldo::class, 'id_usuario');
    }

    public function multa()
    {
        return $this->hasMany(Multa::class, 'id_multa');
    }
    
}
