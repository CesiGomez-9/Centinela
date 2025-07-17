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
        Schema::table('facturas', function (Blueprint $table) {
            // Eliminar la columna 'proveedor' (string) porque ya existe 'proveedor_id'
            if (Schema::hasColumn('facturas', 'proveedor')) {
                $table->dropColumn('proveedor');
            }

            // Eliminar la columna 'producto_id' (es un error de diseño si los productos se manejan vía 'detalles')
            if (Schema::hasColumn('facturas', 'producto_id')) {
                // Primero, eliminar la clave foránea si existe
                $table->dropForeign(['producto_id']);
                $table->dropColumn('producto_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facturas', function (Blueprint $table) {
            // Estas acciones de rollback son solo ejemplos.
            // Si necesitas revertir completamente, deberías restaurar el estado anterior.
            // Para este caso, no se recomienda revertir estas eliminaciones si el sistema depende de los IDs.
        });
    }
};
