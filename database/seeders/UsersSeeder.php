<?php

namespace Database\Seeders;

use App\Models\Administrativo;
use App\Models\Cliente;
use App\Models\EstadoCliente;
use App\Models\Inspector;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Role::all(); // 1 = admin, 2 = inspector, 3 = cliente
        $estados = EstadoCliente::all(); // 1 = activo, 2 = suspendido
        
        $this->crearUsuarioAdministrativo($roles[0]);
        $this->crearUsuarioInspector($roles[1]);
        $this->crearUsuarioCliente($roles[2], $estados[0]);
        
        for ($i = 0; $i < 50; $i++) {
            
            $rol = $roles->random();
            $usuario = User::factory()->create([
                'id_rol' => $rol->id,
            ]);

            switch ($rol->name) {
                case 'cliente':
                    $estado = $estados->random();
                    Cliente::create([
                        'id_usuario' => $usuario->id_usuario,
                        'id_estado_cliente' => $estado->id_estado,
                        'puntaje' => rand(-200, 1000),
                        'saldo' => rand(0, 10000) / 100,
                    ]);
                    break;

                case 'inspector':
                    Inspector::create([
                        'id_usuario' => $usuario->id_usuario,
                    ]);
                    break;

                case 'administrativo':
                    Administrativo::create([
                        'id_usuario' => $usuario->id_usuario,
                    ]);
                    break;

                default:
                    break;
            }
        };
    }

    private function crearUsuarioCliente($rol, $estado_cliente) 
    {
        $usuario = User::create([
            'nombre' => 'Juan',
            'apellido' => 'Perez',
            'email' => 'clientebike1@gmail.com',
            'numero_telefono' => '2974999999',
            'contrasenia' => Hash::make('12345678'),
            'id_rol' => $rol->id,
        ]);

        Cliente::create([
            'id_usuario' => $usuario->id_usuario,
            'id_estado_cliente' => $estado_cliente->id_estado,
            'puntaje' => 50,
            'saldo' => 500,
        ]);
    }
    private function crearUsuarioInspector($rol) 
    {
        $usuario = User::create([
            'nombre' => 'Federico',
            'apellido' => 'Colapinto',
            'email' => 'inspectorbike1@gmail.com',
            'numero_telefono' => '2974999999',
            'contrasenia' => Hash::make('12345678'),
            'id_rol' => $rol->id,
        ]);

        Inspector::create([
            'id_usuario' => $usuario->id_usuario,
        ]);
    }
    private function crearUsuarioAdministrativo($rol) 
    {
        $usuario = User::create([
            'nombre' => 'Lionel',
            'apellido' => 'Messi',
            'email' => 'admbike15@gmail.com',
            'numero_telefono' => '2974999999',
            'contrasenia' => Hash::make('12345678'),
            'id_rol' => $rol->id,
        ]);

        Administrativo::create([
            'id_usuario' => $usuario->id_usuario,
        ]);
    }
}
