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


        Schema::create('instalaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->unsignedBigInteger('empleado_id');
            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');
            $table->unsignedBigInteger('servicio_id');
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade');
            $table->unsignedBigInteger('factura_id')->nullable();
            $table->foreign('factura_id')->references('id')->on('facturas_ventas')->onDelete('set null');
            $table->date('fecha_instalacion');
            $table->decimal('costo_instalacion', 10, 2);
            $table->string('descripcion', 255);
            $table->string('direccion', 255);
            $table->timestamps();
        });
    }

        /**
         * Reverse the migrations.
         */
        public function down(): void
    {
        Schema::dropIfExists('instalaciones');
    }
};
