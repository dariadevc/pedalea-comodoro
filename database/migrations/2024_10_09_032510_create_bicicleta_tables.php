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
        Schema::create('estados_bicicleta', function (Blueprint $table) {
            $table->id('id_estado');
            $table->string('nombre');
        });

        Schema::create('bicicletas', function (Blueprint $table) {
            $table->id('id_bicicleta');
            $table->foreignId('id_estado')->constrained('estados_bicicleta', 'id_estado')->onDelete('cascade');
            $table->foreignId('id_estacion_actual')->nullable()->constrained('estaciones', 'id_estacion')->onDelete('cascade');
            $table->string('patente', 3)->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bicicletas');
        Schema::dropIfExists('estados_bicicleta');
    }
};
