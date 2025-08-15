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
        Schema::create('facturas_compras', function (Blueprint $table) {
            $table->id();
            $table->string('numero_factura')->unique();
            $table->date('fecha');
            $table->enum('forma_pago', [ 'Cheque', 'Efectivo', 'Transferencia'])->default('Efectivo');

            $table->decimal('importe_gravado', 10, 2)->default(0);
            $table->decimal('importe_exento', 10, 2)->default(0);
            $table->decimal('importe_exonerado', 10, 2)->default(0);
            $table->decimal('isv_15', 10, 2)->default(0);
            $table->decimal('isv_18', 10, 2)->default(0);

            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('impuestos', 10, 2)->default(0);
            $table->decimal('totalF', 10, 2)->default(0);

            $table->unsignedBigInteger('responsable_id');
            $table->foreign('responsable_id')->references('id')->on('empleados')->onDelete('cascade');

            $table->unsignedBigInteger('proveedor_id');
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas_compras');
    }
};
