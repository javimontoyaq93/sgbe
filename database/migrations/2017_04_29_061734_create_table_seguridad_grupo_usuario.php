<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSeguridadGrupoUsuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguridad_grupo_usuario', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 50)->unique();
            $table->string('descripcion', 500)->nullable();
            $table->boolean('eliminado')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('seguridad_users_grupo_usuario', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('grupo_id')->unsigned()->index();
            $table->foreign('grupo_id')->references('id')->on('seguridad_grupo_usuario')->onDelete('cascade');

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
        Schema::drop('seguridad_grupo_usuario');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        Schema::dropIfExists('seguridad_users_grupo_usuario');
    }
}
