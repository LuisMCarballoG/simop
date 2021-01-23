<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoalicionPartidoTable extends Migration
{
    public function up()
    {
        Schema::create('coalicion_partido', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('coalicion_id');
            $table->unsignedInteger('partido_id');
            $table->foreign('coalicion_id')->references('id')->on('coalicion')->onDelete('cascade');;
            $table->foreign('partido_id')->references('id')->on('partido')->onDelete('cascade');;
        });
    }

    public function down()
    {
        Schema::dropIfExists('coalicion_partido');
    }
}