<?php

use Illuminate\Support\Facades\Schema as S;
use Illuminate\Database\Schema\Blueprint as B;
use Illuminate\Database\Migrations\Migration as M;

class CreateMunicipiosTable extends M
{
    public function up()
    {
        S::create('municipio', function (B $t) {
            $t->increments('id');
            $t->string('name')->unique();
        });
    }

    public function down(){S::dropIfExists('municipio');}
}