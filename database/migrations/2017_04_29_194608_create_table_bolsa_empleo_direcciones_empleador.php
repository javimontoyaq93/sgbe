<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBolsaEmpleoDireccionesEmpleador extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bolsa_empleo_direcciones_empleadores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('empleador_id')->unsigned()->index();
            $table->boolean('eliminado')->nullable()->default('0');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id')->references('id')->on('core_direcciones');
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
        Schema::dropIfExists('bolsa_empleo_direcciones_empleadores');
    }
}
