<?php

use Illuminate\Support\Facades\Schema as S;
use Illuminate\Database\Schema\Blueprint as B;
use Illuminate\Database\Migrations\Migration as M;

class CreateAdscritosTable extends M
{
    public function up()
    {
        S::create('adscrito', function (B $t) {
            $t->increments('id');
            $t->integer('anio_id')->unsigned();
            $t->integer('seccion_id')->unsigned();
            $t->integer('militante_id')->unsigned();
            $t->integer('lider_id')->unsigned();
            $t->foreign('anio_id')->references('id')->on('anio')->onDelete('cascade');
            $t->foreign('seccion_id')->references('id')->on('seccion')->onDelete('cascade');
            $t->foreign('militante_id')->references('id')->on('militante')->onDelete('cascade');
            $t->foreign('lider_id')->references('id')->on('lider')->onDelete('cascade');
        });
    }

    public function down(){S::dropIfExists('adscrito');}
}