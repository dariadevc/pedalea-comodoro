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
            ConfiguracionesSeeder::class,
            RolesSeeder::class,
            EstadosClienteSeeder::class,
            UsersSeeder::class,
            RangosPuntosSeeder::class,
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
            TiposDanioSeeder::class,
            DaniosSeeder::class,
            HistorialesDanioSeeder::class,
            EstadosReservaSeeder::class,
            ReservasSeeder::class,
            CalificacionesSeeder::class,
            HistorialesSaldoSeeder::class,
            InfraccionesSeeder::class,
            DaniosPorUsoSeeder::class,
            PuntajesDevolucionSeeder::class,
        ]);
    }
}
