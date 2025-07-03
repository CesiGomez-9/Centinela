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
        Schema::table('facturas', function (Blueprint $table) {
            // Eliminar la columna 'proveedor' (string) porque ya existe 'proveedor_id'
            if (Schema::hasColumn('facturas', 'proveedor')) {
                $table->dropColumn('proveedor');
            }

            // Eliminar la columna 'producto_id' (es un error de diseño si los productos se manejan vía 'detalles')
            if (Schema::hasColumn('facturas', 'producto_id')) {
                // Primero, eliminar la clave foránea si existe
                $table->dropForeign(['producto_id']);
                $table->dropColumn('producto_id');
            }

            // Si por alguna razón 'responsable' (string) existiera y fuera redundante con 'responsable_id', se eliminaría.
            // Pero según tu migración original, 'responsable' (string) no estaba, solo 'responsable_id'.
            // Así que no es necesario añadirlo aquí a menos que lo hayas añadido manualmente antes.

            // Opcional: Si quieres renombrar 'responsable_id' a 'empleado_id' para mayor claridad.
            // Si ya tienes datos, esto puede requerir un paso adicional de mapeo.
            // Por ahora, lo mantendremos como 'responsable_id' para minimizar el impacto.
            // $table->renameColumn('responsable_id', 'empleado_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facturas', function (Blueprint $table) {
            // Revertir los cambios en caso de rollback
            // Es importante que estas reversiones sean coherentes con el estado anterior de tu DB.

            // Si eliminaste 'proveedor', podrías querer añadirlo de nuevo si haces rollback
            // $table->string('proveedor')->nullable(); // O con las propiedades originales

            // Si eliminaste 'producto_id', podrías querer añadirlo de nuevo si haces rollback
            // $table->unsignedBigInteger('producto_id')->nullable();
            // $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');

            // Si renombraste 'responsable_id' a 'empleado_id', revertirlo
            // $table->renameColumn('empleado_id', 'responsable_id');
        });
    }
};
