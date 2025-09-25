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
        Schema::create('incidencias', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('tipo',);
            $table->string('descripcion');
            $table->string('ubicacion');


            $table->foreignId('agente_id')->nullable()->constrained('empleados')->nullOnDelete();
            $table->foreignId('reportado_por')->nullable()->constrained('empleados')->nullOnDelete();
            $table->foreignId('cliente_id')->nullable()->constrained('clientes')->nullOnDelete();
            $table->enum('estado', ['en proceso', 'resuelta', 'cerrada'])->default('en proceso');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidencias');
    }
};
