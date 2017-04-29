<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBolsaEmpleoDireccionesPostulante extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bolsa_empleo_direcciones_postulantes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('postulante_id')->unsigned()->index();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id')->references('id')->on('core_direcciones');
            $table->foreign('postulante_id')->references('id')->on('bolsa_empleo_postulantes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bolsa_empleo_direcciones_postulantes');
    }
}
