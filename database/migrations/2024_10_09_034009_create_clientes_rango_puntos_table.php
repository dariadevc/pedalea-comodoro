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
        Schema::create('clientes_rangos_puntos', function (Blueprint $table) {
            $table->foreignId('id_usuario')->constrained('clientes', 'id_usuario')->onDelete('cascade');  // Clave foránea a clientes
            $table->foreignId('id_rango_puntos')->constrained('rangos_puntos', 'id_rango_puntos')->onDelete('cascade');  // Clave foránea a rango_puntos
            
            $table->boolean('multa_hecha_por_dia')->default(false);
            $table->boolean('suspension_hecha_por_dia')->default(false);
            $table->integer('cantidad_veces')->default(0);

            $table->unique(['id_usuario', 'id_rango_puntos']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes_rangos_puntos');
    }
};
