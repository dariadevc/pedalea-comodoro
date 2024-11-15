<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Models\Cliente;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class RegistroClienteRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta solicitud.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtiene las reglas de validación que se aplican a la solicitud.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'dni' => ['required', 'numeric', 'between:20000000,99999999', 'digits:8', 'unique:' . User::class],
            'nombre' => ['required', 'string', 'max:25', 'regex:/^[\pL\s]+$/u'],
            'apellido' => ['required', 'string', 'max:25', 'regex:/^[\pL\s]+$/u'],
            'numero_telefono' => ['required', 'regex:/^\+54[0-9]{10}$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    /**
     * Obtiene los mensajes de error personalizados para la validación.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'dni.required' => 'El DNI es obligatorio.',
            'dni.digits' => 'El DNI debe tener exactamente 8 dígitos.',
            'dni.unique' => 'Este DNI ya está registrado.',
            'dni.between' => 'El DNI debe estar entre 20.000.000 y 99.999.999',
            'dni.numeric' => 'El DNI debe contener solo números.',
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'nombre.max' => 'El nombre no debe exceder los 25 caracteres.',
            'nombre.regex' => 'El nombre solo debe contener letras y espacios.',
            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.string' => 'El apellido debe ser una cadena de texto.',
            'apellido.max' => 'El apellido no debe exceder los 25 caracteres.',
            'apellido.regex' => 'El apellido solo debe contener letras y espacios.',
            'numero_telefono.required' => 'El número de teléfono es obligatorio.',
            'numero_telefono.regex' => 'El número de teléfono debe comenzar con +54 seguido de 10 dígitos.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }

    /**
     * Prepara los datos para la validación.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => strtolower($this->email),
        ]);
    }
}
