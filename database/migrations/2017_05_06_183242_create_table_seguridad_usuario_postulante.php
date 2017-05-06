<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSeguridadUsuarioPostulante extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguridad_usuarios_postulantes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('postulante_id')->unsigned()->index();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id')->references('id')->on('seguridad_usuarios');
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
        Schema::dropIfExists('seguridad_usuarios_postulantes');
    }
}
