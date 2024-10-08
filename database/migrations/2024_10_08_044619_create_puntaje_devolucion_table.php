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
    Schema::create('puntaje_devolucion', function (Blueprint $table) {
        $table->id(); 
        $table->time('tope_horario_entrega');     
        $table->integer('puntaje');           
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puntaje_devolucion');
    }
};
