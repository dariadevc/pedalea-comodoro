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

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false; // Desactivar marcas de tiempo

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'dni',
        'nombre',
        'apellido',
        'email',
        'numero_telefono',
        'password',
    ];

    protected $guarded = [
        'id_usuario',
    ];

    /**
     * Los atributos que deben ocultarse para la serialización.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deben ser convertidos a otros tipos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // 'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    /**
     * Busca un usuario por su DNI.
     *
     * @param string $dni
     * @return self|null
     */
    public static function obtenerUsuarioPorDni(string $dni): ?self
    {
        return self::where('dni', $dni)->first();
    }

    /**
     * Busca un usuario por su ID.
     *
     * @param int $id
     * @return self|null
     */
    public static function obtenerUsuarioPorId(int $id): ?self
    {
        return self::where('id_usuario', $id)->first();
    }
    
    /**
     * Obtiene el cliente asociado al usuario.
     *
     * @return Cliente|null
     */
    public function obtenerCliente(): ?Cliente
    {
        return Cliente::where('id_usuario', $this->id_usuario)->first();
    }

    /**
     * Relación uno a uno con el modelo Cliente.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cliente(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Cliente::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Relación uno a uno con el modelo Administrativo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function administrativo(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Administrativo::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Relación uno a uno con el modelo Inspector.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function inspector(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Inspector::class, 'id_usuario', 'id_usuario');
    }

}
