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
        Schema::table('detalles', function (Blueprint $table) {
            // Add the 'product_id' column
            // Placed after 'factura_id' for logical ordering
            if (!Schema::hasColumn('detalles', 'product_id')) {
                // Añadir la columna 'product_id' después de 'factura_id'
                $table->unsignedBigInteger('product_id')->nullable()->after('factura_id');

                // Set up the foreign key relationship to the 'productos' table
                // onDelete('set null') means that if the product is deleted,
                // the 'product_id' in 'detalles' will be set to null,
                // but the detail record itself will not be deleted.
                // Change to 'cascade' if you prefer to delete the detail when the product is deleted.
                $table->foreign('product_id')->references('id')->on('productos')->onDelete('set null');

                // The 'producto' (string) and 'categoria' (string) columns are kept
                // as they are used to store the name and category in the detail,
                // even if the original product is deleted or modified.
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalles', function (Blueprint $table) {
            // Drop the foreign key and the column in case of rollback
            if (Schema::hasColumn('detalles', 'product_id')) {
                $table->dropForeign(['product_id']);
                $table->dropColumn('product_id');
            }
        });
    }
};

