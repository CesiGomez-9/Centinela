<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImpuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('impuestos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique(); // Por ejemplo: "Exento", "15%", "18%"
            $table->integer('porcentaje'); //  0 para exento, 15 para 15%, 18 para 18%
            $table->timestamps();
        });

        // Opcional: Insertar los tipos de impuestos predefinidos
        // Los porcentajes ahora son enteros
        \DB::table('impuestos')->insert([
            ['nombre' => 'Exento', 'porcentaje' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'No Exento¬>', 'porcentaje' => 15, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'No Exento->', 'porcentaje' => 18, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('impuestos');
    }
}
