<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBolsaEmpleoPostulnte extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bolsa_empleo_postulante', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombres', 250);
            $table->string('apellidos', 250);
            $table->string('numero_documento', 25)->unique();
            $table->string('telefono', 25)->nullable();
            $table->string('celular', 25)->nullable();
            $table->boolean('eliminado')->nullable();
            $table->integer('tipo_documento')->unsigned()->index();
            $table->integer('estado_civil')->unsigned()->index();
            $table->integer('genero')->unsigned()->index();
            $table->foreign('tipo_documento')->references('id')->on('core_catalogo_item');
            $table->foreign('estado_civil')->references('id')->on('core_catalogo_item');
            $table->foreign('genero')->references('id')->on('core_catalogo_item');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bolsa_empleo_postulante');
    }
}
