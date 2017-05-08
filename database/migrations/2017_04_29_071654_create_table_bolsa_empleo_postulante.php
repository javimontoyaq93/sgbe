<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBolsaEmpleoPostulante extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bolsa_empleo_postulantes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombres', 250);
            $table->string('apellidos', 250);
            $table->string('email', 100);
            $table->string('numero_identificacion', 25)->unique();
            $table->string('celular', 25)->nullable();
            $table->boolean('eliminado')->nullable()->default('0');
            $table->integer('tipo_identificacion')->unsigned()->index();
            $table->integer('estado_civil')->unsigned()->index();
            $table->integer('genero')->unsigned()->index();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('tipo_identificacion')->references('id')->on('core_catalogos_items');
            $table->foreign('estado_civil')->references('id')->on('core_catalogos_items');
            $table->foreign('genero')->references('id')->on('core_catalogos_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bolsa_empleo_postulantes');
    }
}
