<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCoreDirecciones20170506 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('core_direcciones', function (Blueprint $table) {
            $table->integer('provincia')->unsigned()->index()->nullable();
        });
    }

}
