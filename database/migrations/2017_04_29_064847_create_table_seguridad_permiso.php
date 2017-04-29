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
        Schema::create('seguridad_permiso', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 250);
            $table->string('codigo', 50)->unique();
            $table->boolean('eliminado')->nullable();
        });
        Schema::create('seguridad_grupo_usuario_permiso', function (Blueprint $table) {
            $table->integer('grupo_id')->unsigned()->index();
            $table->foreign('grupo_id')->references('id')->on('seguridad_grupo_usuario')->onDelete('cascade');
            $table->integer('permiso_id')->unsigned()->index();
            $table->foreign('permiso_id')->references('id')->on('seguridad_permiso')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('seguridad_users_permiso', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('permiso_id')->unsigned()->index();
            $table->foreign('permiso_id')->references('id')->on('seguridad_permiso')->onDelete('cascade');

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
        Schema::drop('seguridad_permiso');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        //Schema::dropIfExists('seguridad_permiso');
        Schema::dropIfExists('seguridad_users_permiso');
        Schema::dropIfExists('seguridad_grupo_usuario_permiso');
    }
}
