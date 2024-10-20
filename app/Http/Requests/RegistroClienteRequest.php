<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegistroClienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'dni' => ['required', 'numeric', 'between:20000000,99999999', 'digits:8', 'unique:'.User::class],
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'numero_telefono' => ['required', 'regex:/^\+54[0-9]{10}$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'dni.required' => 'El DNI es obligatorio.',
            'dni.digits' => 'El DNI debe tener exactamente 8 dígitos.',
            'dni.unique' => 'Este DNI ya está registrado.',
            'dni.between' => 'El DNI debe estar entre 20.000.000 y 99.999.999',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'numero_telefono.required' => 'El número de teléfono es obligatorio.',
            'numero_telefono.regex' => 'El número de teléfono debe comenzar con +54 seguido de 10 digítos.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'email' => strtolower($this->email),
        ]);
    }
}
