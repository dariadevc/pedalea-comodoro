<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrativo extends Model
{

    use HasFactory;

    protected $table = 'administrativos';
    public $timestamps = false; // Desactivar marcas de tiempo

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
