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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('serie')->unique();
            $table->string('codigo')->unique();
            $table->string('nombre');
            $table->string('marca')->nullable(); // Ahora es requerido en el controlador, pero nullable aquí por si acaso
            $table->string('modelo')->nullable(); // Ahora es requerido en el controlador, pero nullable aquí por si acaso
            $table->integer('cantidad')->default(0); // Cantidad inicial del inventario
            $table->boolean('es_exento')->default(false); // true para exento (0% IVA), false para no exento (15% IVA)
            $table->string('categoria');
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
