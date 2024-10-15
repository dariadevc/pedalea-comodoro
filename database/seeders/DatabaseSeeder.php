<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            EstadosClienteSeeder::class,
            UsersSeeder::class,
            RangosPuntosSeeder::class,
            HistorialesSaldoSeeder::class,
            EstadosMultaSeeder::class,
            MultasSeeder::class,
            EstadosSuspensionSeeder::class,
            SuspensionesSeeder::class,
            ClientesRangosPuntosSeeder::class,
            EstadosEstacionSeeder::class,
            EstacionesSeeder::class,
            EstadosBicicletaSeeder::class,
            BicicletasSeeder::class,
            TiposCalificacionSeeder::class,
            CalificacionesSeeder::class,
            TiposDanioSeeder::class,
            DaniosSeeder::class,
            HistorialesDanioSeeder::class,
            EstadosReservaSeeder::class,
            ReservasSeeder::class,
            InfraccionesSeeder::class,
            DaniosPorUsoSeeder::class,
            PuntajesDevolucionSeeder::class,
        ]);
    }
}
