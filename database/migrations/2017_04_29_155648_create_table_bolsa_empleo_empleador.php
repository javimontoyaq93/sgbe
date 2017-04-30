<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBolsaEmpleoEmpleador extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bolsa_empleo_empleadores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 100);
            $table->string('numero_identificacion', 25)->unique();
            $table->string('razon_social', 250);
            $table->integer('actividad_economica')->unsigned()->index();
            $table->integer('tipo_identificacion')->unsigned()->index();
            $table->integer('tipo_personeria')->unsigned()->index();
            $table->boolean('eliminado')->nullable();
            $table->string('celular', 25)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('tipo_identificacion')->references('id')->on('core_catalogos_items');
            $table->foreign('actividad_economica')->references('id')->on('core_catalogos_items');
            $table->foreign('tipo_personeria')->references('id')->on('core_catalogos_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bolsa_empleo_empleadores');
    }
}
