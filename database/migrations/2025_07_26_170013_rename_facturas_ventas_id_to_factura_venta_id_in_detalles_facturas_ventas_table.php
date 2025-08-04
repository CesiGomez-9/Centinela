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
        Schema::table('detalles_facturas_ventas', function (Blueprint $table) {
            $table->renameColumn('facturas_ventas_id', 'factura_venta_id');
        });
    }

    public function down()
    {
        Schema::table('detalles_facturas_ventas', function (Blueprint $table) {
            $table->renameColumn('factura_venta_id', 'facturas_ventas_id');
        });
    }
};
