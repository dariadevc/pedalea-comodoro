<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('estados_reserva', function (Blueprint $table) {
            $table->id('id_estado_reserva');
            $table->string('nombre');
        });


        Schema::create('reservas', function (Blueprint $table) {
            $table->id('id_reserva');
            $table->foreignId('id_bicicleta')->constrained('bicicletas', 'id_bicicleta')->onDelete('cascade');
            $table->foreignId('id_estacion_retiro')->constrained('estaciones', 'id_estacion')->onDelete('cascade');
            $table->foreignId('id_estacion_devolucion')->constrained('estaciones', 'id_estacion')->onDelete('cascade');
            $table->foreignId('id_estado_reserva')->constrained('estados_reserva', 'id_estado_reserva')->onDelete('cascade');
            $table->foreignId('id_cliente_reservo')->constrained('clientes', 'id_usuario')->onDelete('cascade');
            $table->foreignId('id_cliente_devuelve')->constrained('clientes', 'id_usuario')->onDelete('cascade');
            $table->dateTime('fecha_hora_retiro');
            $table->datetime('fecha_hora_devolucion');
            $table->double('monto');
            $table->double('seña');
            $table->integer('puntaje_obtenido');
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estados_reserva');
        Schema::dropIfExists('reservas');

    }
};
