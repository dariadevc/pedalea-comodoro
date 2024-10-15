<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspector extends User
{
    use HasFactory;

    protected $table = 'inspectores';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false; // Desactivar marcas de tiempo

    protected $fillable = [
        'id_usuario',
    ];

    public function infracciones()
    {
        return $this->hasMany(Infraccion::class, 'id_usuario_inspector', 'id_usuario');
    }
}
