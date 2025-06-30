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
            $table->date('fecha');
            $table->string('proveedor');
            $table->enum('forma_pago', ['Efectivo', 'Cheque', 'Transferencia'])->default('Efectivo');
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('impuestos', 10, 2)->default(0);
            $table->decimal('totalF', 10, 2)->default(0);
            $table->unsignedBigInteger('responsable_id');
            $table->foreign('responsable_id')->references('id')->on('empleados')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
