<?php

use Illuminate\Support\Facades\Schema as S;
use Illuminate\Database\Schema\Blueprint as B;
use Illuminate\Database\Migrations\Migration as M;

class CreateEleccionesTable extends M
{
    public function up()
    {
        S::create('eleccion', function (B $t) {
            $t->increments('id');
            $t->integer('anio_id')->unsigned();
            $t->integer('partido_id')->unsigned()->nullable();
            $t->integer('coalicion_id')->unsigned()->nullable();
            $t->integer('seccion_id')->unsigned();
            $t->integer('total')->default('0')->nullable();
            $t->foreign('anio_id')->references('id')->on('anio')->onDelete('cascade');
            $t->foreign('partido_id')->references('id')->on('partido')->onDelete('cascade');
            $t->foreign('coalicion_id')->references('id')->on('coalicion')->onDelete('cascade');
            $t->foreign('seccion_id')->references('id')->on('seccion')->onDelete('cascade');
        });
    }

    public function down()
    {
        S::dropIfExists('eleccion');
    }
}