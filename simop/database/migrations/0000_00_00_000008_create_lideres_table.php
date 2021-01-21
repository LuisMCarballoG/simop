<?php

use Illuminate\Support\Facades\Schema as S;
use Illuminate\Database\Schema\Blueprint as B;
use Illuminate\Database\Migrations\Migration as M;

class CreateLideresTable extends M
{
    public function up()
    {
        S::create('lider', function (B $t) {
            $t->increments('id');
            $t->string('name');
            $t->string('apat');
            $t->string('amat');
            $t->string('ife');
            $t->longText('dir');
        });
    }

    public function down()
    {
        S::dropIfExists('lider');
    }
}