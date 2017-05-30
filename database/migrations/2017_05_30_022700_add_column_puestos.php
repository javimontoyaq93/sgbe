<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPuestos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bolsa_empleo_puestos', function (Blueprint $table) {
            $table->integer('empleador_id')->unsigned()->index()->nullable();
            $table->foreign('empleador_id')->references('id')->on('bolsa_empleo_empleadores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bolsa_empleo_puestos');
    }
}
