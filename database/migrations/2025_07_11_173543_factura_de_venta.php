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
        Schema::create('facturas_ventas', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique(); // número de factura
            $table->unsignedBigInteger('cliente_id'); // relación con clientes
            $table->date('fecha');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('impuestos', 12, 2);
            $table->decimal('total', 12, 2);
            $table->enum('forma_pago', ['Efectivo', 'Cheque', 'Transferencia'])->default('Efectivo');
            $table->timestamps();

            $table->unsignedBigInteger('responsable_id');
            $table->foreign('responsable_id')->references('id')->on('empleados')->onDelete('cascade');

            // Llave foránea para cliente (asumiendo que tienes tabla clientes)
          //  $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas_ventas');
    }
};
