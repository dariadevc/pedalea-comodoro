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


    /**
     * Define la relación de pertenencia con el modelo Danio.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function danios(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Danio::class, 'id_tipo_danio', 'id_tipo_danio');
    }
}
