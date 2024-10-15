<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('puntajes_devolucion', function (Blueprint $table) {
        $table->id('id_puntaje_devolucion'); 
        $table->integer('tope_horario_entrega');     
        $table->integer('puntaje_sin_danio');
        $table->integer('puntaje_con_danio_recuperable');
        $table->integer('puntaje_con_danio_no_recuperable');           
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puntajes_devolucion');
    }
};
