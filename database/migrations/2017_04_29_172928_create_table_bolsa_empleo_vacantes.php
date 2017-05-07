<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBolsaEmpleoVacantes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bolsa_empleo_vacantes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion', 250);
            $table->integer('numero_vacante');
            $table->boolean('eliminado')->nullable()->default('0');
            $table->integer('puesto_id')->unsigned()->index();
            $table->integer('oferta_empleo_id')->unsigned()->index();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('puesto_id')->references('id')->on('bolsa_empleo_puestos');
            $table->foreign('oferta_empleo_id')->references('id')->on('bolsa_empleo_ofertas_empleos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('bolsa_empleo_vacantes');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
