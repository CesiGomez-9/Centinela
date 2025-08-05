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
            $table->integer('costo'); // Hasta 4 cifras, sin decimales (según validación)
            $table->tinyInteger('duracion_cantidad'); // Cantidad numérica
            $table->enum('duracion_tipo', ['horas', 'dias', 'meses', 'años']); // Unidad de tiempo
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
