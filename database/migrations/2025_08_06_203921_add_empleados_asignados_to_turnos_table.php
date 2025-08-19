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
            if (Schema::hasColumn('turnos', 'empleado_id')) {
                $table->dropForeign('turnos_empleado_id_foreign');
                $table->dropColumn('empleado_id');
            }

            if (!Schema::hasColumn('turnos', 'empleados_asignados')) {
                $table->json('empleados_asignados')->after('servicio_id');
            }

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
            if (Schema::hasColumn('turnos', 'empleados_asignados')) {
                $table->dropColumn('empleados_asignados');
            }

            if (!Schema::hasColumn('turnos', 'empleado_id')) {
                $table->foreignId('empleado_id')->nullable()->constrained('empleados')->onDelete('cascade');
            }
        });
    }
};
