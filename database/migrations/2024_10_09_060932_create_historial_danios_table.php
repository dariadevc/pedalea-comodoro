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
        Schema::create('historial_danios', function (Blueprint $table) {
            // En laravel las entidades débiles de manejan usando FK y agregandole la eliminación de cascada, para expresar la dependencia de la entidad débil por la fuerte
            $table->foreignId('id_bicicleta')->constrained('bicicletas', 'id_bicicleta')->onDelete('cascade');
            $table->integer('id_historial_danio');
            $table->timestamp('fecha');

            $table->primary(['id_bicicleta', 'id_historial_danio']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_danio');
    }
};
