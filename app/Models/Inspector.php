<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspector extends Model
{
    use HasFactory;

    protected $table = 'inspectores';
    public $timestamps = false; // Desactivar marcas de tiempo


    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function infracciones()
    {
        return $this->hasMany(Infraccion::class, 'id_usuario_inspector', 'id_usuario');
    }
}
