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
        Schema::create('clientes', function (Blueprint $table) {
            $table->foreignId('id_usuario')
            ->constrained('usuarios', 'id_usuario')
            ->onDelete('cascade') 
            ->primary(); 
            $table->integer('puntaje');
            $table->double('saldo');


        });
        
        Schema::create('inspectores', function (Blueprint $table) {
            $table->foreignId('id_usuario')
            ->constrained('usuarios', 'id_usuario')
            ->onDelete('cascade') 
            ->primary();

        });
        

        Schema::create('administrativos', function (Blueprint $table) {
            $table->foreignId('id_usuario')
            ->constrained('usuarios', 'id_usuario')
            ->onDelete('cascade')
            ->primary();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
        Schema::dropIfExists('inspectores');
        Schema::dropIfExists('administrativos');
    }
};
