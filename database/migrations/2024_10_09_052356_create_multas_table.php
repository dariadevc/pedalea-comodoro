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
        Schema::create('estados_multa', function (Blueprint $table) {
            $table->id('id_estado');
            $table->string('nombre');
        });

        Schema::create('multas', function (Blueprint $table) {
            $table->id('id_multa');
            $table->foreignId('id_usuario')->constrained('clientes', 'id_usuario')->onDelete('cascade'); 
            $table->foreignId('id_estado')->constrained('estados_multa', 'id_estado')->onDelete('cascade'); 
            $table->double('monto');
            $table->datetime('fecha_hora');
            $table->string('descripcion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estados_multa');
        Schema::dropIfExists('multas');
    }
};
