<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSeguridadMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguridad_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 50)->unique();
            $table->string('descripcion', 500)->nullable();
            $table->integer('orden')->nullable();
            $table->boolean('eliminado')->nullable();
            $table->integer('padre_id')->unsigned()->index()->nullable();
            $table->string('formulario', 250);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('seguridad_grupos_usuarios_menus', function (Blueprint $table) {
            $table->integer('grupo_id')->unsigned()->index();
            $table->foreign('grupo_id')->references('id')->on('seguridad_grupos_usuarios')->onDelete('cascade');
            $table->integer('menu_id')->unsigned()->index();
            $table->foreign('menu_id')->references('id')->on('seguridad_menus')->onDelete('cascade');

            $table->timestamps();
        });
        Schema::create('seguridad_usuarios_menus', function (Blueprint $table) {
            $table->integer('usuario_id')->unsigned()->index();
            $table->foreign('usuario_id')->references('id')->on('seguridad_usuarios')->onDelete('cascade');
            $table->integer('menu_id')->unsigned()->index();
            $table->foreign('menu_id')->references('id')->on('seguridad_menus')->onDelete('cascade');
            $table->timestamps();
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
        Schema::drop('seguridad_menus');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('seguridad_grupos_usuarios_menus');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        Schema::dropIfExists('seguridad_usuarios_menus');
    }
}
