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
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion');
            $table->enum('categoria', ['vigilancia', 'tecnico']); // Categoría del servicio

            // Añadimos las nuevas columnas para los costos de cada turno
            $table->decimal('costo_diurno', 8, 2)->nullable()->comment('Costo para el turno diurno');
            $table->decimal('costo_nocturno', 8, 2)->nullable()->comment('Costo para el turno nocturno');
            $table->decimal('costo_24_horas', 8, 2)->nullable()->comment('Costo para el turno de 24 horas');

            $table->json('productos')->nullable(); // Guardamos array de IDs de productos
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};
