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
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->integer('cantidad')->default(0); // Cantidad inicial del inventario
            $table->foreignId('impuesto_id') // Nueva columna para la clave foránea
            ->constrained('impuestos') // Relaciona con la tabla 'impuestos'
            ->onDelete('restrict'); // Evita borrar un impuesto si hay productos asociados

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
