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
        //Crea la tabla de tipos_danio
        Schema::create('tipos_danio', function (Blueprint $table) {
            $table->id('id_tipo_danio');
            $table->string('descripcion');
        });

        //Crea la tabla de danios
        Schema::create('danios', function (Blueprint $table) {
            $table->id('id_danio');
            $table->foreignId('id_tipo_danio')
                ->constrained('tipos_danio', 'id_tipo_danio')
                ->onDelete('cascade');
            $table->string('descripcion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_danio');
        Schema::dropIfExists('danios');
    }
};
