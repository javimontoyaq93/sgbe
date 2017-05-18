<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCoreCatalogo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_catalogos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre')->unique();
            $table->string('descripcion')->nullable();
            $table->integer('orden')->nullable();
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
        Schema::dropIfExists('core_catalogos');
    }
}
