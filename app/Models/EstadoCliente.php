<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoCliente extends Model
{

    use HasFactory;
    
    protected $table = 'estados_clientes';
    public $timestamps = false;


    protected $fillable = [
        'nombre',
    ];

    public function clientes(){
        return $this->hasMany(Cliente::class, 'id_estado_cliente', 'id_estado');
    }

}
