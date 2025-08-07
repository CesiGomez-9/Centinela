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
        Schema::table('instalaciones', function (Blueprint $table) {
            // Eliminar la clave foránea antes de borrar la columna
            $table->dropForeign(['empleado_id']);
            $table->dropColumn('empleado_id');
        });
    }

    public function down(): void
    {
        Schema::table('instalaciones', function (Blueprint $table) {
            $table->foreignId('empleado_id')
                ->constrained('empleados')
                ->onDelete('cascade');
        });
    }
};
