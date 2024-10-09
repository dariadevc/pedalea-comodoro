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
        Schema::create('estados_estacion', function (Blueprint $table) {
            $table->id('id_estado');
            $table->string('nombre');
        });

        Schema::create('estaciones', function (Blueprint $table) {
            $table->id('id_estacion');
            $table->foreignId('id_estado')->constrained('estados_estacion', 'id_estado')->onDelete('cascade');
            $table->string('nombre');
            $table->decimal('latitud', 10, 8);
            $table->decimal('longitud', 11, 8);
            $table->decimal('calificacion', 4, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estaciones');
        Schema::dropIfExists('estados_estacion');
    }
};
