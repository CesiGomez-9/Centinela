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
            $table->string('nombre_servicio');
            $table->text('descripcion');
            $table->string('direccion');
            $table->string('ciudad');
            $table->date('fecha_inicio');
            $table->string('duracion');
            $table->string('horario');
            $table->integer('cantidad_personal');
            $table->string('tipo_personal');
            $table->boolean('incluye_equipamiento')->default(false);
            $table->date('fecha_solicitud');
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
