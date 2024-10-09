<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('historiales_saldo', function (Blueprint $table) {
            $table->foreignId('id_usuario') 
            ->constrained('clientes', 'id_usuario')
            ->onDelete('cascade');
            $table->bigIncrements('id_historial_saldo');
            $table->date('fecha_hora');
            $table->double('monto');
            $table->text('motivo');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historiales_saldo');
    }
};
