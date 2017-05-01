<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBolsaEmpleoDetallesVacantes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bolsa_empleo_detalles_vacantes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 250);
            $table->string('descripcion', 500);
            $table->boolean('eliminado');
            $table->integer('vacante_id')->unsigned()->index();
            $table->integer('padre_id')->unsigned()->index();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('vacante_id')->references('id')->on('bolsa_empleo_vacantes');
            $table->foreign('padre_id')->references('id')->on('bolsa_empleo_detalles_vacantes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bolsa_empleo_detalles_vacantes');
    }
}
