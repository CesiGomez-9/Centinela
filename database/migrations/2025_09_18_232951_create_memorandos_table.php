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
        Schema::create('memorandos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('autor_id');
            $table->unsignedBigInteger('destinatario_id');
            $table->string('titulo');
            $table->text('contenido');
            $table->date('fecha');
            $table->string('tipo');
            $table->text('sancion');
            $table->string('adjunto')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
            $table->foreign('autor_id')
                ->references('id')->on('empleados')
                ->onDelete('cascade');
            $table->foreign('destinatario_id')
                ->references('id')->on('empleados')
                ->onDelete('cascade');
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memorandos');
    }
};
