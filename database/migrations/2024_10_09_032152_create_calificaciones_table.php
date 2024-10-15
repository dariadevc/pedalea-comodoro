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
        Schema::create('tipos_calificacion', function (Blueprint $table) {
            $table->id('id_tipo_calificacion');
            $table->integer('cantidad_estrellas');
        });

        Schema::create('calificaciones', function (Blueprint $table) {
            $table->id('id_calificacion');
            $table->foreignId('id_estacion')->constrained('estaciones', 'id_estacion')->onDelete('cascade');
            $table->foreignId('id_tipo_calificacion')->constrained('tipos_calificacion', 'id_tipo_calificacion')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calificaciones');
        Schema::dropIfExists('tipos_calificacion');
    }
};
