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
        // Añade las columnas 'precio_compra' y 'precio_venta' a la tabla 'productos'.
        Schema::table('productos', function (Blueprint $table) {
            // Verifica si la columna 'precio_compra' ya existe para evitar errores.
            if (!Schema::hasColumn('productos', 'precio_compra')) {
                $table->decimal('precio_compra', 10, 2)->default(0.00)->after('cantidad');
            }
            // Verifica si la columna 'precio_venta' ya existe para evitar errores.
            if (!Schema::hasColumn('productos', 'precio_venta')) {
                $table->decimal('precio_venta', 10, 2)->default(0.00)->after('precio_compra');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Elimina las columnas 'precio_venta' y 'precio_compra' al revertir la migración.
        Schema::table('productos', function (Blueprint $table) {
            if (Schema::hasColumn('productos', 'precio_venta')) {
                $table->dropColumn('precio_venta');
            }
            if (Schema::hasColumn('productos', 'precio_compra')) {
                $table->dropColumn('precio_compra');
            }
        });
    }
};

