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
        Schema::create('estado_estacion', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_estado');
        });

        Schema::create('estacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estado_id')->constrained('estado_estacion')->onDelete('cascade');
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
        Schema::dropIfExists('estacion');
    }
};
