<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->string('descripcion', 125);
            $table->enum('categoria', ['vigilancia', 'tecnico']);
            $table->enum('tipo_personal', ['vigilancia', 'tecnico']);
            $table->unsignedSmallInteger('costo'); // hasta 999
            $table->unsignedTinyInteger('duracion_cantidad');
            $table->enum('duracion_tipo', ['horas', 'dias', 'meses', 'años']);
            $table->json('productos_tecnico')->nullable();
            $table->json('productos_vigilancia')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('servicios');
    }
};
