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
        if (!Schema::hasColumn('detalles_facturas_ventas', 'responsable_id')) {
            Schema::table('detalles_facturas_ventas', function (Blueprint $table) {
                $table->unsignedBigInteger('responsable_id')->after('producto_id');
                $table->foreign('responsable_id')->references('id')->on('empleados')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::table('detalles_facturas_ventas', function (Blueprint $table) {
            $table->dropForeign(['responsable_id']);
            $table->dropColumn('responsable_id');
        });
    }

};
