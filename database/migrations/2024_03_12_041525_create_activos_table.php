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
        Schema::create('activos', function (Blueprint $table) {
            $table->id();
            $table->date("fechaDeCompra");
            $table->string("idContabilidad");
            $table->enum("estadoActivo", ['Disponible', 'Asignado', 'Reparacion', 'Descartado'])->default('Disponible');
            $table->boolean("estado");
            $table->unsignedBigInteger('cliente_id');
            $table->foreign(['cliente_id'])->references(['id'])->on('clientes')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('departamento_id');
            $table->foreign(['departamento_id'])->references(['id'])->on('departamentos')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('producto_id');
            $table->foreign(['producto_id'])->references(['id'])->on('productos')->onUpdate('CASCADE')->onDelete('CASCADE');
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
        Schema::dropIfExists('activos');
    }
};
