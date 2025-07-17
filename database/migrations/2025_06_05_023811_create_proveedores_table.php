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
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('nombreEmpresa',50);
            $table->string('direccion',150);
            $table->string('telefonodeempresa',8);
            $table->string('correoempresa',100)->unique();
            $table->string('nombrerepresentante',50);
            $table->string('telefonoderepresentante',8);
            $table->string('categoriarubro');
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};
