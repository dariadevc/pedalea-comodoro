<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDanio extends Model
{
    use HasFactory;

    protected $table = 'tipos_danio';

    // Los atributos que pueden modificarse
    protected $fillable = [
        'descripcion',
    ];

    // Los atributos que no pueden modificarse
    protected $guarded = [
        'id_tipo_danio',
    ];

    public function danio()
    {
        return $this->hasMany(Danio::class, 'id_danio', 'id_tipo_danio');
    }
}
