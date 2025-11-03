<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detalles_facturas_ventas', function (Blueprint $table) {
            if (Schema::hasColumn('detalles_facturas_ventas', 'detalle_factura_id')) {
                $table->dropForeign(['detalle_factura_id']);
                $table->dropColumn('detalle_factura_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('detalles_facturas_ventas', function (Blueprint $table) {
            $table->unsignedBigInteger('detalle_factura_id')->nullable();
            $table->foreign('detalle_factura_id')->references('id')->on('detalles');
        });
    }
};
