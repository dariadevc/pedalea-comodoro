<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoCliente extends Model
{

    use HasFactory;
    
    protected $table = 'estados_clientes';
    protected $primaryKey = 'id_estado';
    public $timestamps = false;

    public const ACTIVO = 1;
    public const SUSPENDIDO = 2;

    protected $fillable = [
        'nombre',
    ];

    /**
     * Define la relación de pertenencia con el modelo Cliente.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clientes()
    {
        return $this->hasMany(Cliente::class, 'id_estado_cliente', 'id_estado');
    }

}
