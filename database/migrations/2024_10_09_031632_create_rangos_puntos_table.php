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
        Schema::create('rangos_puntos', function (Blueprint $table) {
            $table->id('id_rango_puntos');
            $table->integer('rango_minimo');
            $table->integer('rango_maximo');
            $table->double('monto_multa')->nullable();
            $table->integer('tiempo_suspension_dias')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rangos_puntos');
    }
};
