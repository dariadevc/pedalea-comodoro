<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDanio extends Model
{
    use HasFactory;

    protected $table = 'tipos_danio';
    protected $primaryKey = 'id_tipo_danio';
    public $timestamps = false;

    // Los atributos que pueden modificarse
    protected $fillable = [
        'descripcion',
    ];

    // Los atributos que no pueden modificarse
    protected $guarded = [
        'id_tipo_danio',
    ];

    public function danios()
    {
        return $this->hasMany(Danio::class, 'id_tipo_danio', 'id_tipo_danio');
    }
}
