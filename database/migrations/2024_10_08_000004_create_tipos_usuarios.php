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
        {
            Schema::create('estados_clientes', function (Blueprint $table) {
                $table->id('id_estado');
                $table->string('nombre');
            });
        }

        Schema::create('clientes', function (Blueprint $table) {
            $table->foreignId('id_usuario')
            ->constrained('usuarios', 'id_usuario')
            ->onDelete('cascade');
            $table->foreignId('id_estado_cliente')->constrained('estados_clientes', 'id_estado');
            $table->integer('puntaje');
            $table->double('saldo');
            $table->primary(['id_usuario']);


        });
        
        Schema::create('inspectores', function (Blueprint $table) {
            $table->foreignId('id_usuario')
            ->constrained('usuarios', 'id_usuario')
            ->onDelete('cascade');
            
            $table->primary(['id_usuario']);

        });
        

        Schema::create('administrativos', function (Blueprint $table) {
            $table->foreignId('id_usuario')
            ->constrained('usuarios', 'id_usuario')
            ->onDelete('cascade');
            $table->primary(['id_usuario']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estados_clientes');
        Schema::dropIfExists('clientes');
        Schema::dropIfExists('inspectores');
        Schema::dropIfExists('administrativos');
    }
};
