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
        Schema::table('activos', function (Blueprint $table) {
            $table->boolean("garantia");
            $table->date('fecha_inicio_garantia')->nullable();
            $table->date('fecha_final_garantia')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activos', function (Blueprint $table) {
            $table->dropColumn('garantia');
            $table->dropColumn('fecha_inicio_garantia');
            $table->dropColumn('fecha_final_garantia');
        });
    }
};
