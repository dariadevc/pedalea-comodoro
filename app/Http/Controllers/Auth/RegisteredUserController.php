<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistroClienteRequest;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('invitado.registrarse');
    }


    public function store(RegistroClienteRequest $request): RedirectResponse
    {
        $user = User::create([
            'dni' => $request->dni,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'numero_telefono' => $request->numero_telefono,
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('cliente');

        Cliente::create([
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'id_usuario' => $user->id_usuario,
            'id_estado_cliente' => 1,
            'puntaje' => 0,
            'saldo' => 0.00,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('cliente.inicio'));
    }
}
