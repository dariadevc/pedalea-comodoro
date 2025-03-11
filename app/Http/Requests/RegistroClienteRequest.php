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

    public function rules(): array
    {
        return [
            'dni' => ['required', 'numeric', 'between:10000000,99999999', 'digits:8', 'unique:' . User::class],
            'nombre' => ['required', 'string', 'max:25', 'min:2', 'regex:/^[\pL\s]+$/u'],
            'apellido' => ['required', 'string', 'max:25', 'min:2', 'regex:/^[\pL\s]+$/u'],
            'numero_telefono' => ['required', 'numeric', 'digits:10'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'max:255',
                'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,255}$/',
            ],
            'fecha_nacimiento' => [
                'required',
                'date',
                'before_or_equal:' . now()->subYears(13)->toDateString(),
                'after_or_equal:' . now()->subYears(100)->toDateString()
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'dni.required' => 'El DNI es obligatorio.',
            'dni.digits' => 'El DNI debe tener exactamente 8 dígitos.',
            'dni.unique' => 'Este DNI ya está registrado.',
            'dni.between' => 'El DNI debe estar entre 10.000.000 y 99.999.999',
            'dni.numeric' => 'El DNI debe contener solo números.',
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'nombre.max' => 'El nombre no debe exceder los 25 caracteres.',
            'nombre.min' => 'El nombre debe tener al menos 2 caracteres.',
            'nombre.regex' => 'El nombre solo debe contener letras y espacios.',
            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.string' => 'El apellido debe ser una cadena de texto.',
            'apellido.max' => 'El apellido no debe exceder los 25 caracteres.',
            'apellido.min' => 'El apellido debe tener al menos 2 caracteres.',
            'apellido.regex' => 'El apellido solo debe contener letras y espacios.',
            'numero_telefono.required' => 'El número de celular es obligatorio.',
            'numero_telefono.numeric' => 'El número de celular debe contener solo números.',
            'numero_telefono.digits' => 'El número de celular debe tener exactamente 10 dígitos.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.regex' => 'La contraseña debe tener al menos una letra, un número y un carácter especial.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.max' => 'La contraseña no debe exceder los 255 caracteres.',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha_nacimiento.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'fecha_nacimiento.before_or_equal' => 'Debes tener al menos 13 años.',
            'fecha_nacimiento.after_or_equal' => 'La edad no puede superar los 100 años.',
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
