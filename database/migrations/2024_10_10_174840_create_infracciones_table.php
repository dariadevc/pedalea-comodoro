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
        Schema::create('infracciones', function (Blueprint $table) {
            $table->id('id_infraccion');
            $table->foreignId('id_usuario_cliente')->constrained('clientes', 'id_usuario')->onDelete('cascade');
            $table->foreignId('id_reserva')->constrained('reservas', 'id_reserva')->onDelete('cascade');
            $table->foreignId('id_usuario_inspector')->constrained('inspectores', 'id_usuario')->onDelete('cascade');
            $table->integer('cantidad_puntos');
            $table->dateTime('fecha_hora');
            $table->text('motivo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infracciones');
    }
};
