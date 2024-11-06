<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoMulta extends Model
{
    use HasFactory;

    protected $table = 'estados_multa';
    protected $primaryKey = 'id_estado';
    public $timestamps = false;


    protected $fillable = [
        'nombre',
    ];

    public function multas()
    {
        return $this->hasMany(Multa::class, 'id_estado', 'id_estado');
    }




}
