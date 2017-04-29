<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBolsaEmpleoPuesto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bolsa_empleo_puestos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('denominacion', 250);
            $table->boolean('eliminado')->nullable();
            $table->integer('area_conocimiento')->unsigned()->index();
            $table->integer('nivel_instruccion')->unsigned()->index();
            $table->integer('tiempo_experiencia');
            $table->boolean('remuneracion', 12, 2);
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('bolsa_empleo_puestos');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
