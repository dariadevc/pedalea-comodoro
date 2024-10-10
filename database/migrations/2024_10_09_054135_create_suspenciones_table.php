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
        Schema::create('estado_suspensiones', function (Blueprint $table) {
            $table->id('id_estado_suspensiones');
            $table->string('nombre');
        });

        Schema::create('suspensiones', function (Blueprint $table) {
            $table->id('id_suspensiones');
            $table->foreignId('id_usuario')->constrained('clientes', 'id_usuario')->onDelete('cascade');
            $table->foreignId('id_estado_suspensiones')->constrained('estado_suspensiones', 'id_estado_suspensiones')->onDelete('cascade');
            $table->date('fecha_desde');
            $table->date('fecha_hasta');
            $table->string('descripcion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suspensiones');
        Schema::dropIfExists('estado_suspensiones');
    }
};
