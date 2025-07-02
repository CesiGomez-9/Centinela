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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('identidad')->unique();
            $table->string('direccion');
            $table->string('email')->unique();
            $table->string('telefono')->unique();
            $table->string('contactodeemergencia');
            $table->string('telefonodeemergencia');
            $table->string('tipodesangre');
            $table->text('alergias')->nullable();
            $table->string('alergiaOtros', 150)->nullable();
            $table->string('alergiaAlimentos', 150)->nullable();
            $table->string('alergiaMedicamentos', 150)->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
