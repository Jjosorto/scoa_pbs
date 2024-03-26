<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mantenimiento_activos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_registro');
            $table->string('descripcion')->nullable();
            $table->enum("estadoActivo", ['Disponible', 'Asignado', 'Reparacion', 'Descartado'])->default('Disponible');
            $table->unsignedBigInteger('activo_id');
            $table->foreign(['activo_id'])->references(['id'])->on('activos')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mantenimiento_activos');
    }
};
