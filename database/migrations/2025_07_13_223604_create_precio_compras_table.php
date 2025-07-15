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
        // Crea la tabla 'precio_compras' para almacenar el historial de precios de compra de los productos.
        Schema::create('precio_compras', function (Blueprint $table) {
            $table->id(); // Columna de ID auto-incremental
            // Clave foránea que referencia el ID de un producto en la tabla 'productos'.
            // Cuando un producto es eliminado, sus registros de precio de compra también se eliminarán (onDelete('cascade')).
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->decimal('precio_compra', 10, 2); // Precio de compra, con 10 dígitos en total y 2 decimales.
            $table->timestamps(); // Columnas 'created_at' y 'updated_at' para registrar la fecha del precio.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Elimina la tabla 'precio_compras' al revertir la migración.
        Schema::dropIfExists('precio_compras');
    }
};

