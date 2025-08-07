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
        Schema::table('facturas_compras', function (Blueprint $table) {
            if (Schema::hasColumn('facturas_compras', 'proveedor')) {
                $table->dropColumn('proveedor');
            }


            if (Schema::hasColumn('facturas_compras', 'producto_id')) {
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
        Schema::table('facturas_compras', function (Blueprint $table) {
            // Estas acciones de rollback son solo ejemplos.
            // Si necesitas revertir completamente, deberías restaurar el estado anterior.
            // Para este caso, no se recomienda revertir estas eliminaciones si el sistema depende de los IDs.
        });
    }
};
