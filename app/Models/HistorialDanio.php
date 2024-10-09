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
}
