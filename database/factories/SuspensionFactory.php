<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\EstadoSuspension;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Suspension>
 */
class SuspensionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_usuario' => Cliente::where('id_usuario', '<>', 3)->inRandomOrder()->first()->id_usuario,
            'id_estado' => EstadoSuspension::inRandomOrder()->first()->id_estado,
            'fecha_desde' => $this->faker->date(),
            'fecha_hasta' => $this->faker->date(),
            'fecha_hora' => $this->faker->dateTime(),
            'descripcion' => 'Acumulacion de puntaje negativo',
        ];
    }
}
