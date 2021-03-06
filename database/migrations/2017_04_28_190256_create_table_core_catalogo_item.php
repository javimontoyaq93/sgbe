<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCoreCatalogoItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_catalogos_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->integer('orden')->nullable();
            $table->boolean('eliminado')->nullable();
            $table->integer('catalogo_id')->unsigned()->index();
            $table->integer('padre_id')->unsigned()->index()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('catalogo_id')->references('id')->on('core_catalogos');
            $table->foreign('padre_id')->references('id')->on('core_catalogos_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('core_catalogos_items');
    }
}
