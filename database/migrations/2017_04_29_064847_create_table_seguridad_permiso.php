<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSeguridadPermiso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguridad_permisos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 250);
            $table->string('codigo', 50)->unique();
            $table->boolean('eliminado')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
        Schema::create('seguridad_grupo_usuarios_permisos', function (Blueprint $table) {
            $table->integer('grupo_id')->unsigned()->index();
            $table->foreign('grupo_id')->references('id')->on('seguridad_grupos_usuarios')->onDelete('cascade');
            $table->integer('permiso_id')->unsigned()->index();
            $table->foreign('permiso_id')->references('id')->on('seguridad_permisos')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('seguridad_usuarios_permisos', function (Blueprint $table) {
            $table->integer('usuario_id')->unsigned()->index();
            $table->foreign('usuario_id')->references('id')->on('seguridad_usuarios')->onDelete('cascade');
            $table->integer('permiso_id')->unsigned()->index();
            $table->foreign('permiso_id')->references('id')->on('seguridad_permisos')->onDelete('cascade');

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
        Schema::drop('seguridad_permisos');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        Schema::dropIfExists('seguridad_usuarios_permisos');
        Schema::dropIfExists('seguridad_grupo_usuarios_permisos');
    }
}
