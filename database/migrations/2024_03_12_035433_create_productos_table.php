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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
            $table->string("serie");
            $table->string("ram")->nullable();
            $table->string("procesador")->nullable();
            $table->enum("tipoDisco", ['HDD','SSD','NVMe','M.2'])->default(null)->nullable();
            $table->string("capacidadDisco")->nullable();
            $table->string("descripcion");
            $table->boolean("estadoProductos");
            $table->unsignedBigInteger('modelo_id');
            $table->foreign(['modelo_id'])->references(['id'])->on('modelos')->onUpdate('CASCADE')->onDelete('CASCADE');
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
        Schema::dropIfExists('productos');
    }
};
