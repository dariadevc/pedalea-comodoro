<?php

namespace Database\Seeders;

use App\Models\EstadoCliente;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Role::all();
        $estados = EstadoCliente::all();

        for ($i = 0; $i < 100; $i++) {
            $rol = $roles->random();
            $usuario = User::factory()->create([
                'id_rol' => $rol->id,

            ]);
            switch ($rol->name) {
                case 'cliente':
                    $estado = $estados->random();
                    $usuario->cliente()->create([
                        'id_estado_cliente' => $estado->id_estado,
                        'puntaje' => rand(-200, 1000),
                        'saldo' => rand(0, 10000) / 100,
                    ]);
                    break;

                case 'inspector':
                    $usuario->inspector()->create();
                    break;

                case 'administrativo':
                    $usuario->administrativo()->create();
                    break;

                default:
                    break;
            }
        };
    }
}
