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
        Schema::create('tipo_calificaciones', function (Blueprint $table) {
            $table->id('id_tipo_calificaciones');
            $table->integer('cantidad_estrellas');
        });

        Schema::create('calificiones', function (Blueprint $table) {
            $table->id('id_calificaciones');
            $table->foreignId('id_estacion')->constrained('estaciones', 'id_estacion')->onDelete('cascade');
            $table->foreignId('id_tipo_calificaciones')->constrained('tipo_calificaciones', 'id_tipo_calificaciones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calificiones');
        Schema::dropIfExists('tipo_calificiones');
    }
};
