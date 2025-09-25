
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

            $table->foreignId('factura_venta_id')->constrained('facturas_ventas')->onDelete('cascade');
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->foreignId('responsable_id')->constrained('empleados')->onDelete('cascade');

            $table->string('nombre');
            $table->string('categoria')->nullable();
            $table->decimal('precio_venta', 12, 2);
            $table->integer('cantidad');
            $table->decimal('iva', 5, 2);
            $table->decimal('subtotal', 12, 2);

            $table->timestamps();
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
