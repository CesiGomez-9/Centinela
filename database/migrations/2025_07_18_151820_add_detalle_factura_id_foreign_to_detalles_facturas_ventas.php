
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
        Schema::table('detalles_facturas_ventas', function (Blueprint $table) {
            if (!Schema::hasColumn('detalles_facturas_ventas', 'detalle_factura_id')) {
                $table->unsignedBigInteger('detalle_factura_id')->after('id');
            }

            $table->foreign('detalle_factura_id')
                ->references('id')->on('detalles')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalles_facturas_ventas', function (Blueprint $table) {

            $table->dropForeign(['detalle_factura_id']);

        });
    }
};
