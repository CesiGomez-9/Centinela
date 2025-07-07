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
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->string('numero_factura')->unique();
            $table->date('fecha');;
            $table->enum('forma_pago', ['Efectivo', 'Cheque', 'Transferencia'])->default('Efectivo');
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('impuestos', 10, 2)->default(0);
            $table->decimal('totalF', 10, 2)->default(0);
            $table->unsignedBigInteger('responsable_id');
            $table->foreign('responsable_id')->references('id')->on('empleados')->onDelete('cascade');
            $table->unsignedBigInteger('proveedor_id');
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade');
            $table->unsignedBigInteger('producto_id');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->dropForeign(['proveedor_id']);
            $table->dropColumn('proveedor_id');
        });
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('facturas');
        Schema::dropIfExists('empleados');
        Schema::dropIfExists('proveedores');
        Schema::dropIfExists('productos');
        Schema::enableForeignKeyConstraints();
    }
};
