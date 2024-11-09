<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspector extends Model
{
    use HasFactory;

    protected $table = 'inspectores';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false; // Desactivar marcas de tiempo

    protected $fillable = [
        'id_usuario',
    ];

    /**
     * Devuelve las infracciones asociadas al inspector.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function infracciones(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Infraccion::class, 'id_usuario_inspector', 'id_usuario');
    }

    /**
     * Devuelve el usuario asociado al inspector.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }
}
