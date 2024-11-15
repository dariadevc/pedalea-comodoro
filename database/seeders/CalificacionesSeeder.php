<?php

namespace Database\Seeders;

use App\Models\Calificacion;
use App\Models\Estacion;
use App\Models\EstadoReserva;
use App\Models\Reserva;
use App\Models\TipoCalificacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CalificacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos_calificacion = TipoCalificacion::all();
        $reservas = Reserva::where('id_estado', EstadoReserva::FINALIZADA)->get();

        foreach ($reservas as $reserva) {
            Calificacion::create([
                'id_estacion' => $reserva->id_estacion_devolucion,
                'id_tipo_calificacion' => $tipos_calificacion->random()->id_tipo_calificacion,
            ]);
            Calificacion::create([
                'id_estacion' => $reserva->id_estacion_retiro,
                'id_tipo_calificacion' => $tipos_calificacion->random()->id_tipo_calificacion,
            ]);
        }

    }
}
