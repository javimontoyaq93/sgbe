<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBolsaEmpleoOfertasEmpleos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bolsa_empleo_ofertas_empleos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion', 250);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->boolean('eliminado')->nullable()->default('0');
            $table->integer('empleador_id')->unsigned()->index();
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('bolsa_empleo_ofertas_empleos');
    }
}
