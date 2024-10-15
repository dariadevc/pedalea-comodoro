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
        Schema::create('estados_suspension', function (Blueprint $table) {
            $table->id('id_estado');
            $table->string('nombre');
        });

        Schema::create('suspensiones', function (Blueprint $table) {
            $table->id('id_suspension');
            $table->foreignId('id_usuario')->constrained('clientes', 'id_usuario')->onDelete('cascade');
            $table->foreignId('id_estado')->constrained('estados_suspension', 'id_estado')->onDelete('cascade');
            $table->date('fecha_desde');
            $table->date('fecha_hasta');
            $table->datetime('fecha_hora');
            $table->string('descripcion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suspensiones');
        Schema::dropIfExists('estados_suspension');
    }
};
