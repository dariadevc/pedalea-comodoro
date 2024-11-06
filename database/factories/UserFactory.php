<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'dni' => $this->generarDni(),
            'nombre' => fake()->name(),
            'apellido' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'numero_telefono' => fake()->phoneNumber(),
            'password' => Hash::make(fake()->password()),
            // 'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }


    private function generarDni()
    {
        do {
            $dni = mt_rand(10000000, 50000000);
        } while (User::where('dni', $dni)->exists());
        return $dni;
    }
    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
