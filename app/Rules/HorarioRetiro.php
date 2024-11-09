<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\ValidationRule;

class HorarioRetiro implements ValidationRule
{
    protected $inicio;
    protected $fin;

    /**
     * Constructor para definir el rango de horario permitido.
     */
    public function __construct()
    {
        $this->inicio = Carbon::now()->subMinute();
        $this->fin = $this->inicio->copy()->addHours(2)->addMinute();
    }

    /**
     * Valida que el horario de retiro esté dentro del rango permitido.
     *
     * @param string $attribute El nombre del atributo que se está validando
     * @param mixed $value El valor del atributo
     * @param \Closure $fail Función que se llama en caso de que la validación falle
     * @return void
     */
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        $hora = Carbon::parse($value);

        if (!$hora->between($this->inicio, $this->fin)) {
            $fail("El horario de retiro debe estar entre {$this->inicio->addMinute()->format('H:i')} y {$this->fin->format('H:i')}.");
        }
    }
}
