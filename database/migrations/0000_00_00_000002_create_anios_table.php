<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAniosTable extends Migration
{
    public function up()
    {
        Schema::create('anio', function (Blueprint $t) {
            $t->increments('id');
            $t->enum('oculto', ['Y','N'])->default('N');
        });
    }

    public function down()
    {
        Schema::dropIfExists('anio');
    }
}