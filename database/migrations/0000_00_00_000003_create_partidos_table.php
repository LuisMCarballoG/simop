<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartidosTable extends Migration
{
    public function up()
    {
        Schema::create('partido', function (Blueprint $t) {
            $t->increments('id');
            $t->string('name_small')->unique();
            $t->string('name')->unique();
            $t->longtext('foto')->nullable();
            $t->enum('oculto', ['Y','N'])->default('N');
        });
    }

    public function down()
    {
        Schema::dropIfExists('partido');
    }
}