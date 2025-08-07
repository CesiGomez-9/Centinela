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
        Schema::table('turnos', function (Blueprint $table) {
            // Verificamos si la columna 'empleado_id' existe antes de intentar eliminarla.
            if (Schema::hasColumn('turnos', 'empleado_id')) {
                // Primero, eliminamos la clave foránea.
                $table->dropForeign('turnos_empleado_id_foreign');

                // Ahora, eliminamos la columna 'empleado_id'.
                $table->dropColumn('empleado_id');
            }

            // Eliminamos las columnas antiguas que ahora están en el JSON.
            if (Schema::hasColumn('turnos', 'hora_inicio')) {
                $table->dropColumn('hora_inicio');
            }
            if (Schema::hasColumn('turnos', 'hora_fin')) {
                $table->dropColumn('hora_fin');
            }
            if (Schema::hasColumn('turnos', 'tipo_turno')) {
                $table->dropColumn('tipo_turno');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('turnos', function (Blueprint $table) {
            // En caso de revertir la migración, volvemos a crear las columnas.
            if (!Schema::hasColumn('turnos', 'empleado_id')) {
                $table->foreignId('empleado_id')->nullable()->constrained('empleados')->onDelete('cascade');
            }
            if (!Schema::hasColumn('turnos', 'hora_inicio')) {
                $table->time('hora_inicio');
            }
            if (!Schema::hasColumn('turnos', 'hora_fin')) {
                $table->time('hora_fin');
            }
            if (!Schema::hasColumn('turnos', 'tipo_turno')) {
                $table->string('tipo_turno');
            }
        });
    }
};
