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
        Schema::create('seguridad_grupos_usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 50)->unique();
            $table->string('descripcion', 500)->nullable();
            $table->boolean('eliminado')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('seguridad_usuarios_grupos_usuarios', function (Blueprint $table) {
            $table->integer('usuario_id')->unsigned()->index();
            $table->foreign('usuario_id')->references('id')->on('seguridad_usuarios')->onDelete('cascade');
            $table->integer('grupo_usuario_id')->unsigned()->index();
            $table->foreign('grupo_usuario_id')->references('id')->on('seguridad_grupos_usuarios')->onDelete('cascade');
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
        Schema::drop('seguridad_grupos_usuarios');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        Schema::dropIfExists('seguridad_usuarios_grupos_usuarios');
    }
}
