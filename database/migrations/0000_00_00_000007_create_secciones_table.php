<?php

use Illuminate\Support\Facades\Schema as S;
use Illuminate\Database\Schema\Blueprint as B;
use Illuminate\Database\Migrations\Migration as M;

class CreateSeccionesTable extends M
{
    public function up()
    {
        S::create('seccion', function (B $t) {
            $t->increments('id');
            $t->integer('municipio_id')->unsigned();
            $t->integer('name');
            $t->integer('lista_nominal');
            $t->foreign('municipio_id')->references('id')->on('municipio')->onDelete('cascade');
        });
    }

    public function down()
    {
        S::dropIfExists('seccion');
    }
}