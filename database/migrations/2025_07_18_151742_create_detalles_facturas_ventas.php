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
        Schema::create('detalles_facturas_ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('facturas_ventas_id'); // relación con factura venta
            $table->unsignedBigInteger('producto_id'); // producto vendido
            $table->string('nombre'); // para guardar nombre del producto al momento
            $table->string('categoria')->nullable();
            $table->decimal('precio_venta', 12, 2);
            $table->integer('cantidad');
            $table->decimal('iva', 5, 2);
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();

            $table->foreign('facturas_ventas_id')->references('id')->on('facturas_ventas')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreignId('responsable_id')->constrained('empleados')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_facturas_ventas');
    }
};
