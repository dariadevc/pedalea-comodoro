<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\ClienteRangoPuntos;
use App\Models\RangoPuntos;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClientesRangosPuntosSeeder extends Seeder
{
    public function run(): void
    {
        $id_clientes = Cliente::pluck('id_usuario')->toArray();
        $id_rangos_puntos = RangoPuntos::pluck('id_rango_puntos')->toArray();
        $clientes_rangos_puntos = [];

        foreach ($id_clientes as $id_cliente) {
            foreach ($id_rangos_puntos as $id_rango_puntos) {
                $clientes_rangos_puntos[] = [
                    'id_usuario' => $id_cliente,
                    'id_rango_puntos' => $id_rango_puntos,
                    'multa_hecha_por_dia' => false,
                    'suspension_hecha_por_dia' => false,
                    'cantidad_veces' => 0,
                ];
            }
        }

        ClienteRangoPuntos::insert($clientes_rangos_puntos);
    }
}
