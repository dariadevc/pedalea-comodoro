<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoMulta extends Model
{
    use HasFactory;

    protected $table = 'estados_multa';


    protected $fillable = [
        'nombre',
    ];
    //No se pueden modificar:
    protected $guarded = [
        'id_estado_multa',

    ];


    //La rela 1aM 
    public function multa()
    {
        return $this->hasMany(Multa::class, 'id_multa');
    }




}
