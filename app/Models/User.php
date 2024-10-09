<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'usuarios';
    public $timestamps = false; // Desactivar marcas de tiempo

    
    protected $fillable = [
        'id_rol',
        'nombre',
        'apellido',
        'email',
        'numero_telefono',
        'contraseña',
    ];

    protected $guarded = [
        'id_usuario',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'contraseña',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // 'email_verified_at' => 'datetime',
            'contraseña' => 'hashed',
        ];
    }

    // Definición de relaciones
    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'id_usuario');
    }

    public function inspector()
    {
        return $this->hasOne(Inspector::class, 'id_usuario');
    }

    public function administrativo()
    {
        return $this->hasOne(Administrativo::class, 'id_usuario');
    }
}
