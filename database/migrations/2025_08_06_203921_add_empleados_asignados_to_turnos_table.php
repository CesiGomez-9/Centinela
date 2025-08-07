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
                // Usamos el nombre por defecto de Laravel, si es diferente, debes ajustarlo.
                $table->dropForeign('turnos_empleado_id_foreign');

                // Ahora, eliminamos la columna 'empleado_id'.
                $table->dropColumn('empleado_id');
            }

            // Agregamos la nueva columna 'empleados_asignados' solo si no existe.
            if (!Schema::hasColumn('turnos', 'empleados_asignados')) {
                $table->json('empleados_asignados')->after('servicio_id');
            }

            // Agregamos la columna 'fecha_inicio' si no existe.
            if (!Schema::hasColumn('turnos', 'fecha_inicio')) {
                $table->date('fecha_inicio')->after('servicio_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('turnos', function (Blueprint $table) {
            // En caso de revertir la migración, eliminamos la columna 'empleados_asignados'.
            if (Schema::hasColumn('turnos', 'empleados_asignados')) {
                $table->dropColumn('empleados_asignados');
            }

            // Y volvemos a crear la columna 'empleado_id' con su clave foránea.
            // Verificamos que no exista antes de crearla.
            if (!Schema::hasColumn('turnos', 'empleado_id')) {
                $table->foreignId('empleado_id')->nullable()->constrained('empleados')->onDelete('cascade');
            }
        });
    }
};
