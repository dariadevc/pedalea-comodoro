<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\EstadoMulta;
use App\Models\Multa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Multa>
 */
class MultaFactory extends Factory
{
    protected $model = Multa::class;
    public function definition(): array
    {
        return [
            'id_usuario' => Cliente::where('id_usuario', '<>', 3)->inRandomOrder()->first()->id_usuario,
            'id_estado' => EstadoMulta::inRandomOrder()->first()->id_estado,
            'monto' => $this->faker->randomFloat(2, 100, 100000),
            'fecha_hora' => $this->faker->dateTime(),
            'descripcion' => 'Acumulacion de puntaje negativo',
        ];
    }
}
