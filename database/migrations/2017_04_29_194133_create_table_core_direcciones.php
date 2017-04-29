<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCoreDirecciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_direcciones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('referencia', 500);
            $table->string('calles', 250);
            $table->string('telefono', 50)->nullable();
            $table->integer('tipo_direccion')->unsigned()->index();
            $table->integer('pais')->unsigned()->index();
            $table->integer('ciudad')->unsigned()->index();
            $table->boolean('eliminado')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('core_direcciones');
    }
}
