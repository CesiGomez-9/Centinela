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
            $table->dropForeign(['empleado_id']); // usa el nombre del campo entre corchetes
            $table->dropColumn('empleado_id');
        });
    }

    public function down(): void
    {
        Schema::table('instalaciones', function (Blueprint $table) {
            $table->foreignId('empleado_id')->constrained('empleados')->onDelete('cascade');
        });
    }
};
