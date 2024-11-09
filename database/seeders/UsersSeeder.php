<?php

namespace Database\Seeders;

use App\Models\Administrativo;
use App\Models\Cliente;
use App\Models\EstadoCliente;
use App\Models\Inspector;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Testing\Fakes\Fake;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Role::all(); // 1 = admin, 2 = inspector, 3 = cliente
        $estados_cliente = EstadoCliente::all(); // 1 = activo, 2 = suspendido
        
        $this->crearUsuarioAdministrativo($roles[0]);
        $this->crearUsuarioInspector($roles[1]);
        $this->crearUsuarioCliente($roles[2], $estados_cliente[0]);
        

        for ($i = 0; $i < 30; $i++) {
            $rol = $roles[2];
            $usuario = User::factory()->create();
            $usuario->assignRole($rol);
            $estado_cliente = $estados_cliente[0];
            Cliente::create([
                'fecha_nacimiento' => Carbon::now()->subYears(rand(18, 50))->format('Y-m-d'),
                'id_usuario' => $usuario->id_usuario,
                'id_estado_cliente' => $estado_cliente->id_estado,
                'puntaje' => rand(-200, 1000),
                'saldo' => rand(0, 10000) / 100,
            ]);
        }
        for ($i = 0; $i < 5; $i++) {
            $rol = $roles[1];
            $usuario = User::factory()->create();
            $usuario->assignRole($rol);
            Inspector::create([
                'id_usuario' => $usuario->id_usuario,
            ]);
        }
        for ($i = 0; $i < 5; $i++) {
            $rol = $roles[0];
            $usuario = User::factory()->create();
            $usuario->assignRole($rol);
            Administrativo::create([
                'id_usuario' => $usuario->id_usuario,
            ]);
        }
    }

    private function crearUsuarioCliente($rol, $estado_cliente) 
    {
        $usuario = User::create([
            'dni' => 30000000,
            'nombre' => 'Juan',
            'apellido' => 'Perez',
            'email' => 'clientebike1@gmail.com',
            'numero_telefono' => '2974999999',
            'password' => Hash::make('12345678'),
        ]);
        $usuario->assignRole($rol->name);

        Cliente::create([
            'fecha_nacimiento' => Carbon::now()->subYears(rand(18, 50))->format('Y-m-d'),
            'id_usuario' => $usuario->id_usuario,
            'id_estado_cliente' => $estado_cliente->id_estado,
            'puntaje' => 0,
            'saldo' => 0,
        ]);
    }
    private function crearUsuarioInspector($rol) 
    {
        $usuario = User::create([
            'dni' => 30000001,
            'nombre' => 'Federico',
            'apellido' => 'Colapinto',
            'email' => 'inspectorbike1@gmail.com',
            'numero_telefono' => '2974999999',
            'password' => Hash::make('12345678'),
        ]);
        $usuario->assignRole($rol->name);

        Inspector::create([
            'id_usuario' => $usuario->id_usuario,
        ]);
    }
    private function crearUsuarioAdministrativo($rol) 
    {
        $usuario = User::create([
            'dni' => 30000002,
            'nombre' => 'Lionel',
            'apellido' => 'Messi',
            'email' => 'admbike15@gmail.com',
            'numero_telefono' => '2974999999',
            'password' => Hash::make('12345678'),
        ]);
        $usuario->assignRole($rol->name);

        Administrativo::create([
            'id_usuario' => $usuario->id_usuario,
        ]);
    }
}
