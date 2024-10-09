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
        Schema::create('danios_por_uso', function (Blueprint $table) {
            $table->foreignId('id_bicicleta')
                ->constrained('bicicletas', 'id_bicicleta')
                ->onDelete('cascade');

            $table->integer('id_historial_danio');

            $table->foreign(['id_bicicleta', 'id_historial_danio'])
                ->references(['id_bicicleta', 'id_historial_danio'])
                ->on('historiales_danios');

            $table->foreignId('id_danio')
                ->constrained('danios', 'id_danio')
                ->onDelete('cascade');

            $table->primary(['id_bicicleta', 'id_historial_danio', 'id_danio']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('danios_por_uso');
    }
};
