<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Carbon\Carbon;

class HorarioRetiro implements ValidationRule
{
    protected $inicio;
    protected $fin;

    public function __construct()
    {
        $this->inicio = Carbon::now()->subMinute();
        $this->fin = $this->inicio->copy()->addHours(2)->addMinute();
    }

    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        $hora = Carbon::parse($value);

        if (!$hora->between($this->inicio, $this->fin)) {
            $fail("El horario de retiro debe estar entre {$this->inicio->addMinute()->format('H:i')} y {$this->fin->format('H:i')}.");
        }
    }
}
